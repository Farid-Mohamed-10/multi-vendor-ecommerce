<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Stock;
use App\Services\CartService;
use App\Services\StockService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function add(Request $request, CartService $cart, StockService $stockService)
    {
        if (auth()->check() && auth()->user()->hasRole('seller')) {
            return back()->with('error', 'Sellers are not allowed to purchase products.');
        }
        $data = $request->validate([
            'product_id' => ['required', 'integer', 'exists:products,id'],
            'stock_id' => ['required', 'integer', 'exists:stocks,id'],
            'qty' => ['nullable', 'integer', 'min:1'],
            'buy_now'    => ['nullable', 'in:0,1'],
        ]);

        $productId = (int) $data['product_id'];
        $stockId = (int) $data['stock_id'];
        $addQty = (int) ($data['qty'] ?? 1);

        // حماية: تأكد إن stock ده تابع لنفس المنتج
        $stock = Stock::query()
            ->whereKey($stockId)
            ->where('product_id', $productId)
            ->firstOrFail();

        // تحقق كمية (اللي في الكارت + الجديد)
        $requestedTotal = $cart->qtyInCartForStock($stockId) + $addQty;
        $stockService->assertAvailable($stockId, $requestedTotal);

        $product = Product::query()->findOrFail($productId);
        $cart->addStock($product, $stock, $addQty);

        // New
        if (($data['buy_now'] ?? '0') === '1') {
            return redirect()->route('front.checkout.show');
        }

        return back()->with('success', 'Added to cart!');
    }

    public function show(CartService $cart)
    {
        if (auth()->check() && auth()->user()->hasRole('seller')) {
            return redirect()->route('front.index')->with('error', 'Sellers are not allowed to view the cart.');
        }

        return view('front.cart.show', [
            'items' => $cart->items(),
            'subtotal' => $cart->subtotal(),
            'count' => $cart->count(),
        ]);
    }

    public function update(Request $request, int $stockId, CartService $cart, StockService $stockService)
    {
        if (auth()->check() && auth()->user()->hasRole('seller')) {
            return back()->with('error', 'Sellers are not allowed to update the cart.');
        }

        $data = $request->validate([
            'qty' => ['required', 'integer', 'min:0'],
        ]);

        if ($data['qty'] > 0) {
            $stockService->assertAvailable($stockId, (int) $data['qty']);
        }

        $cart->updateQty($stockId, (int) $data['qty']);

        return back();
    }

    public function remove(int $stockId, CartService $cart)
    {
        if (auth()->check() && auth()->user()->hasRole('seller')) {
            return back()->with('error', 'Sellers are not allowed to modify the cart.');
        }

        $cart->remove($stockId);

        return back();
    }
}
