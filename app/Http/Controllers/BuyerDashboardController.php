<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BuyerDashboardController extends Controller
{
  public function overview()
  {
    $user = Auth::user();
    $totalOrders = $user->orders()->count();
    $totalSpent = $user->orders()->where('status', '!=', 'cancelled')->sum('total');
    $pendingOrders = $user->orders()->where('status', 'pending')->count();
    $deliveredOrders = $user->orders()->where('status', 'delivered')->count();
    $recentOrders = $user->orders()->with('items.product')->latest()->take(5)->get();

    return view('buyer-dashboard.index', get_defined_vars());
  }

  public function orders(Request $request)
  {
    $statusFilter = $request->input('status');

    $orders = Auth::user()->orders()->with('items.product')->latest();

    if ($statusFilter) {
      $orders->where('status', $statusFilter);
    }

    $orders = $orders->paginate(10)->withQueryString();

    return view('buyer-dashboard.orders.index', get_defined_vars());
  }

  public function orderShow(Order $order)
  {
    abort_if($order->user_id !== Auth::id(), 403);
    $order->load(['items.product', 'address']);
    return view('buyer-dashboard.orders.show', get_defined_vars());
  }

  public function cancelOrder(Order $order)
  {
    abort_if($order->user_id !== Auth::id(), 403);
    abort_if($order->status !== 'pending', 403, 'Only pending orders can be cancelled.');

    $order->update(['status' => 'cancelled']);
    return redirect()->back()->with('success', 'Order cancelled successfully.');
  }
}
