<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $categoryId = $request->input('category_id');
        $size = $request->input('size');

        $products = Product::query();

        if ($search) {
            $products->where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('price', 'like', "%{$search}%");
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
        $categories = \App\Models\Category::all();
        $sizes = \App\Models\Stock::query()->distinct('size')->pluck('size');

        $products = $products->paginate(10)->withQueryString();

        return view('admin-dashboard.products.index', get_defined_vars());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Product $product)
    {
        return view('admin-dashboard.products.create', get_defined_vars());
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

            return redirect()->route('admin-dashboard.products.index')->with('sucess', 'Product created successfully');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Wrong happend: '.$e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return view('admin-dashboard.products.show', get_defined_vars());
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        return view('admin-dashboard.products.edit', get_defined_vars());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
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

            return redirect()
                ->route('admin-dashboard.products.index')
                ->with('success', 'Product updated successfully');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Wrong happend: '.$e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        try {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }

            $product->delete();

            return redirect()
                ->route('admin-dashboard.products.index')
                ->with('success', 'Product deleted successfully');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Wrong happend: '.$e->getMessage());
        }
    }

    public function showAllProducts()
    {
        // fetch categories for sidebar, include product counts to show numbers
        $categories = Category::withCount('products')->get();

        // base query for products; filters can be applied here if needed later
        $query = Product::query();

        // simple search example (commented out for now)
        if (request('search')) {
            $query->where('name', 'like', '%'.request('search').'%');
        }

        // apply category filter
        if (request('category')) {
            $query->where('category_id', request('category'));
        }

        // apply size filter (via stocks relationship)
        if (request('size')) {
            $query->whereHas('stocks', function ($q) {
                $q->where('size', request('size'));
            });
        }

        // price range filters
        if (request('min_price')) {
            $query->where('price', '>=', request('min_price'));
        }
        if (request('max_price')) {
            $query->where('price', '<=', request('max_price'));
        }

        // sorting
        switch (request('sort')) {
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
        $sizes = \App\Models\Stock::query()
            ->distinct('size')
            ->orderBy('size')
            ->pluck('size');

        // paginate results for better performance
        $products = $query->paginate(24)->withQueryString();

        return view('front.products.show-all-products', compact('products', 'categories', 'sizes'));
    }

    public function showProduct(Product $product)
    {
        return view('front.products.show-product', get_defined_vars());
    }
}
