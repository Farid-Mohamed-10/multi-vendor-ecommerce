<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    protected function currentUser()
    {
        return Auth::user();
    }

    protected function isAdmin(): bool
    {
        return $this->currentUser()->hasRole('admin');
    }

    protected function managedProductsQuery()
    {
        return Product::query()
            ->with(['category', 'stocks'])
            ->when(! $this->isAdmin(), function ($query) {
                $query->where('user_id', Auth::id());
            });
    }

    protected function ensureCanManageProduct(Product $product): void
    {
        if (! $this->isAdmin() && $product->user_id !== Auth::id()) {
            abort(403);
        }
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $categoryId = $request->input('category_id');
        $size = $request->input('size');

        $products = $this->managedProductsQuery();

        if ($search) {
            $products->where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('price', 'like', "%{$search}%")
                    ->orWhereHas('category', function ($categoryQuery) use ($search) {
                        $categoryQuery->where('name', 'like', "%{$search}%");
                    });
            });
        }

        if ($categoryId) {
            $products->where('category_id', $categoryId);
        }

        if ($size) {
            $products->whereHas('stocks', function ($q) use ($size) {
                $q->where('size', $size);
            });
        }

        // classification options for filters
        $categories = Category::all();
        $sizes = Stock::query()->distinct('size')->pluck('size');

        $products = $products->latest()->paginate(10)->withQueryString();

        if ($this->isAdmin()) {
            return view('admin-dashboard.products.index', get_defined_vars());
        }

        return view('seller-dashboard.products.index', get_defined_vars());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if ($this->isAdmin()) {
            return view('admin-dashboard.products.create');
        }

        return view('seller-dashboard.products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        try {
            $data = $request->validated();

            // store file on public disk under products folder
            $data['image'] = $request->file('image')->store('products', 'public');

            $data['user_id'] = auth()->id();

            $product = Product::create($data);

            // Create the stocks
            $product->stocks()->createMany($data['stocks']);

            if ($this->isAdmin()) {
                return redirect()->route('admin-dashboard.products.index')->with('success', 'Product created successfully');
            }
            return redirect()->route('seller-dashboard.products.index')->with('success', 'Product created successfully');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Wrong happend: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $this->ensureCanManageProduct($product);
        $product->load(['category', 'stocks', 'user']);

        if ($this->isAdmin()) {
            return view('admin-dashboard.products.show', get_defined_vars());
        }
        return view('seller-dashboard.products.show', get_defined_vars());
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $this->ensureCanManageProduct($product);
        $product->load(['category', 'stocks']);

        if ($this->isAdmin()) {
            return view('admin-dashboard.products.edit', get_defined_vars());
        }
        return view('seller-dashboard.products.edit', get_defined_vars());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $this->ensureCanManageProduct($product);

        try {
            $data = $request->validated();

            if ($request->hasFile('image')) {
                if ($product->image) {
                    Storage::disk('public')->delete($product->image);
                }
                $data['image'] = $request->file('image')->store('products', 'public');
            } else {
                unset($data['image']);
            }

            $product->update($data);

            if (! empty($data['stocks'])) {
                $product->stocks()->delete();
                $product->stocks()->createMany($data['stocks']);
            }

            if ($this->isAdmin()) {
                return redirect()
                    ->route('admin-dashboard.products.index')
                    ->with('success', 'Product updated successfully');
            }
            return redirect()
                ->route('seller-dashboard.products.index')
                ->with('success', 'Product updated successfully');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Wrong happend: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $this->ensureCanManageProduct($product);

        try {
            if ($product->orderItems()->exists()) {
                return redirect()
                    ->back()
                    ->with('error', 'This product cannot be deleted because it is linked to existing orders. You can edit it or set its stock to 0 instead.');
            }

            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }

            $product->delete();

            if ($this->isAdmin()) {
                return redirect()
                    ->route('admin-dashboard.products.index')
                    ->with('success', 'Product deleted successfully');
            }
            return redirect()
                ->route('seller-dashboard.products.index')
                ->with('success', 'Product deleted successfully');
        } catch (QueryException $e) {
            return redirect()
                ->back()
                ->with('error', 'This product cannot be deleted because it is still referenced by other records.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Wrong happend: ' . $e->getMessage());
        }
    }

    public function showAllProducts(Request $request)
    {
        // fetch categories for sidebar, include product counts to show numbers
        $categories = Category::withCount('products')->get();

        // base query for products; filters can be applied here if needed later
        $query = Product::query()->with('category');
        $search = trim((string) $request->input('search'));

        if ($search !== '') {
            $query->where(function ($productQuery) use ($search) {
                $productQuery
                    ->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhereHas('category', function ($categoryQuery) use ($search) {
                        $categoryQuery->where('name', 'like', "%{$search}%");
                    });
            });
        }

        // apply category filter
        if ($request->filled('category')) {
            $query->where('category_id', $request->input('category'));
        }

        // apply size filter (via stocks relationship)
        if ($request->filled('size')) {
            $query->whereHas('stocks', function ($q) use ($request) {
                $q->where('size', $request->input('size'));
            });
        }

        // price range filters
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->input('min_price'));
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->input('max_price'));
        }

        // sorting
        switch ($request->input('sort')) {
            case 'oldest':
                $query->oldest();
                break;
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            default:
                $query->latest();
                break;
        }

        // prepare filter values for view
        $sizes = Stock::query()
            ->distinct('size')
            ->orderBy('size')
            ->pluck('size');

        // paginate results for better performance
        $products = $query->paginate(24)->withQueryString();

        return view('front.products.show-all-products', compact('products', 'categories', 'sizes'));
    }

    public function showProduct(Product $product)
    {
        // حمّل العلاقات اللي بتستخدمها في الصفحة لتقليل الاستعلامات
        $product->load(['category', 'user', 'stocks']);

        // stocks المتاحة فقط (quantity > 0) عشان ما نعرضش خيارات ميتة
        $availableStocks = $product->stocks->where('quantity', '>', 0)->values();

        // Sizes & Colors (Unique) لعمل dropdowns
        $sizes = $availableStocks->pluck('size')->filter()->unique()->values();
        $colors = $availableStocks->pluck('color')->filter()->unique()->values();

        // خريطة للـ JS عشان يطلع stock_id من size+color
        $stockMap = $availableStocks->map(fn($s) => [
            'id' => $s->id,
            'size' => $s->size,
            'color' => $s->color,
            'qty' => (int) $s->quantity,
        ])->values();

        // New
        $colorImages = $availableStocks
            ->filter(fn($s) => !empty($s->image)) // لو عندك image في stocks
            ->mapWithKeys(fn($s) => [
                $s->color => asset('storage/' . $s->image),
            ])
            ->toArray();

        // لو عندك relatedProducts جهزه هنا (اختياري)
        $relatedProducts = Product::where('category_id', $product->category_id)->whereKeyNot($product->id)->take(10)->get();

        return view('front.products.show-product', get_defined_vars());
    }
}
