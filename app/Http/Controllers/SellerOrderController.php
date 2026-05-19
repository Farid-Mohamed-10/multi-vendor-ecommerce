<?php

namespace App\Http\Controllers;

use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SellerOrderController extends Controller
{
  public function index()
  {
    $user = Auth::user();

    // Get all order items belonging to the seller's products
    $orderItems = OrderItem::with(['order', 'product', 'order.user'])
      ->whereHas('product', function ($query) use ($user) {
        $query->where('user_id', $user->id);
      })
      ->orderBy('created_at', 'desc')
      ->paginate(15);

    return view('seller-dashboard.orders.index', compact('orderItems'));
  }

  public function updateStatus(Request $request, OrderItem $orderItem)
  {
    // Add security check to ensure this seller actually owns the product of this order item
    if ($orderItem->product->user_id !== Auth::id()) {
      abort(403, 'Unauthorized action.');
    }

    $request->validate([
      'status' => 'required|in:pending,processing,shipped,delivered,canceled',
    ]);

    // Note: For multi-vendor, technically the *order* status might be globally applied 
    // OR the seller updates the item status. In this schema, `status` is on the Order model.
    // We will update the global order status for simplicity, or just update it if they are the only seller.
    // Let's assume the Order table has a 'status' column that the seller is allowed to update. 
    // If the system is complex multi-vendor, usually the 'status' should be on the OrderItem. 
    // Since we are limited by schema, we update the main Order status.

    $order = $orderItem->order;
    $order->update(['status' => $request->status]);

    return redirect()->route('seller-dashboard.orders.index')
      ->with('success', 'Order status updated successfully');
  }
}
