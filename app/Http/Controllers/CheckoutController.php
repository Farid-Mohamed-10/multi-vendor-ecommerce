<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\Stock;
use App\Services\CartService;
use App\Services\StockService;
use App\Services\CalcRevenues;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function show(CartService $cart, CalcRevenues $calc)
    {
        if (auth()->check() && auth()->user()->hasRole('seller')) {
            return redirect()->route('front.index')->with('error', 'Sellers are not allowed to purchase products.');
        }

        if ($cart->count() === 0) {
            return redirect()->route('front.cart.show')->with('error', 'Cart is empty');
        }

        $subtotal = $cart->subtotal();

        return view('front.checkout.show', [
            'items' => $cart->items(),
            'subtotal' => $subtotal,
            'tax' => $calc->getTaxAmount($subtotal),
            'shipping' => $calc->getShippingAmount($subtotal),
            'total' => $calc->getTotalAmount($subtotal),
        ]);
    }

    public function place(Request $request, CartService $cart, StockService $stockService, CalcRevenues $calc)
    {
        if (auth()->check() && auth()->user()->hasRole('seller')) {
            return redirect()->route('front.index')->with('error', 'Sellers are not allowed to purchase products.');
        }

        if ($cart->count() === 0) {
            return redirect()->route('front.cart.show')->with('error', 'Cart is empty');
        }

        $rules = [
            'full_name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:30'],
            'address' => ['required', 'string', 'max:500'],
            'city' => ['nullable', 'string', 'max:255'],
            'notes' => ['nullable', 'string', 'max:500'],
        ];

        if (! auth()->check()) {
            $rules['email'] = ['required', 'email', 'max:255'];
        } else {
            $rules['email'] = ['nullable', 'email', 'max:255'];
        }

        $data = $request->validate($rules);
        $cartItems = $cart->items();

        $order = DB::transaction(function () use ($cartItems, $data, $stockService, $calc) {

            // 1) totals (من DB)
            $subtotal = 0;

            foreach ($cartItems as $item) {
                $product = Product::query()->findOrFail($item['product_id']);
                $qty = (int) $item['qty'];
                $stockId = (int) $item['stock_id'];

                // 2) حماية: تأكد stock موجود وتابع للمنتج
                Stock::query()
                    ->whereKey($stockId)
                    ->where('product_id', $product->id)
                    ->firstOrFail();

                // 3) خصم ستوك آمن (lockForUpdate)
                $stockService->deductOrFail($stockId, $qty);

                $lineTotal = (float) $product->price * $qty;
                $subtotal += $lineTotal;
            }

            $taxAmount = $calc->getTaxAmount($subtotal);
            $shippingAmount = $calc->getShippingAmount($subtotal);
            $totalAmount = $calc->getTotalAmount($subtotal);

            // 4) create order (COD confirmed)
            $order = Order::create([
                'order_number' => 'ORD-'.strtoupper(Str::random(10)),
                'user_id' => auth()->id(),
                'email' => $data['email'] ?? auth()->user()?->email,
                'status' => 'confirmed',
                'payment_method' => 'cod',
                'payment_status' => 'unpaid',
                'subtotal' => $subtotal,
                'tax_amount' => $taxAmount,
                'shipping_amount' => $shippingAmount,
                'total' => $totalAmount,
            ]);

            // 5) create items snapshots
            foreach ($cartItems as $item) {
                $product = Product::query()->findOrFail($item['product_id']);
                $qty = (int) $item['qty'];

                $order->items()->create([
                    'product_id' => $product->id,
                    'stock_id' => (int) $item['stock_id'],
                    'name_snapshot' => $product->name,
                    'size_snapshot' => $item['size'],
                    'color_snapshot' => $item['color'],
                    'unit_price_snapshot' => (float) $product->price,
                    'qty' => $qty,
                    'line_total' => (float) $product->price * $qty,
                ]);
            }

            // 6) address
            $order->address()->create([
                'full_name' => $data['full_name'],
                'phone' => $data['phone'],
                'address_line' => $data['address'],
                'city' => $data['city'] ?? null,
                'notes' => $data['notes'] ?? null,
            ]);

            return $order;
        });

        // 7) clear cart
        $cart->clear();

        return redirect()->route('front.order.success', $order);
    }

    public function success(Order $order)
    {
        return view('front.checkout.success', compact('order'));
    }
}
