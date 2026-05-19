<?php

namespace App\Http\Controllers;

use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SellerDashboardController extends Controller
{
  public function index()
  {
    $user = Auth::user();

    // Get total products for this seller
    $totalProducts = Product::where('user_id', $user->id)->count();

    // Get total revenue for this seller. We calculate the difference between price and original price in the orders made
    $totalRevenue = OrderItem::join('products', 'order_items.product_id', '=', 'products.id')
      ->where('products.user_id', $user->id)
      ->sum(DB::raw('(order_items.unit_price_snapshot - products.original_price) * order_items.qty'));

    // Get total orders that contain at least one product from this seller
    $totalOrders = OrderItem::whereHas('product', function ($query) use ($user) {
      $query->where('user_id', $user->id);
    })->distinct('order_id')->count();

    // Get pending orders items for this seller
    $pendingOrders = OrderItem::whereHas('product', function ($query) use ($user) {
      $query->where('user_id', $user->id);
    })->whereHas('order', function ($q) {
      $q->where('status', 'pending');
    })->count();

    // Sales Chart Data (Last 7 Days)
    $last7Days = collect();
    for ($i = 6; $i >= 0; $i--) {
      $last7Days->push(now()->subDays($i)->format('Y-m-d'));
    }

    $salesData = OrderItem::join('products', 'order_items.product_id', '=', 'products.id')
      ->select(
        DB::raw('DATE(order_items.created_at) as date'),
        DB::raw('SUM((order_items.unit_price_snapshot - products.original_price) * order_items.qty) as revenue')
      )
      ->where('products.user_id', $user->id)
      ->where('order_items.created_at', '>=', now()->subDays(6)->startOfDay())
      ->groupBy('date')
      ->pluck('revenue', 'date');

    $chartLabels = [];
    $chartData = [];

    foreach ($last7Days as $day) {
      $chartLabels[] = now()->parse($day)->format('M d');
      $chartData[] = $salesData->get($day, 0);
    }

    // Recent Orders
    $recentOrders = OrderItem::with(['order', 'product', 'order.user'])
      ->whereHas('product', function ($query) use ($user) {
        $query->where('user_id', $user->id);
      })
      ->orderBy('created_at', 'desc')
      ->limit(5)
      ->get();

    return view('seller-dashboard.index', compact(
      'totalProducts',
      'totalRevenue',
      'totalOrders',
      'pendingOrders',
      'chartLabels',
      'chartData',
      'recentOrders'
    ));
  }
}
