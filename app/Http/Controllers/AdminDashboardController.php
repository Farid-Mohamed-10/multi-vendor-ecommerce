<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Services\CalcRevenues;

class AdminDashboardController extends Controller
{
  public function index()
  {
    $usersCount = User::count();
    $productsCount = Product::count();
    $ordersCount = Order::count();
    $orders = Order::with('user')->latest()->take(5)->get();

    $revenue = new CalcRevenues();
    $totalRevenue = $revenue->adminRevenue(Order::where('status', 'confirmed')->sum('subtotal'));

    $categories = Category::withCount('products')->orderByDesc('products_count')->get();

    $palette = ['#7C3AED', '#EC4899', '#F59E0B', '#10B981', '#3B82F6', '#EF4444', '#14B8A6'];

    $top = $categories->take(4);

    $categoryLabels = $top->pluck('name')->values()->toArray();

    $categoryData = $top
      ->map(function ($c) use ($productsCount) {
        return $productsCount ? round(($c->products_count / $productsCount) * 100, 0) : 0;
      })
      ->values()
      ->toArray();

    $categoryColors = $top
      ->values()
      ->map(function ($c, $i) use ($palette) {
        return $palette[$i % count($palette)];
      })
      ->toArray();

    $othersCount = $categories->skip(4)->sum('products_count');
    $othersPercent = $productsCount ? round(($othersCount / $productsCount) * 100, 0) : 0;

    if ($othersPercent > 0) {
      $categoryLabels[] = 'Others';
      $categoryData[] = $othersPercent;
      $categoryColors[] = '#E5E7EB';
    }

    $sum = array_sum($categoryData);
    if ($sum !== 100 && count($categoryData) > 0) {
      $last = count($categoryData) - 1;
      $categoryData[$last] = max(0, $categoryData[$last] + (100 - $sum));
    }

    // Sales Chart Data
    $range = request('range', '7months');
    $salesLabels = [];
    $salesData = [];

    if ($range === '30days') {
      for ($i = 29; $i >= 0; $i--) {
        $date = now()->subDays($i);
        $salesLabels[] = $date->format('d M');
        $salesData[] = Order::where('status', 'confirmed')
          ->whereDate('created_at', $date->toDateString())
          ->sum('total');
      }
    } elseif ($range === 'year') {
      for ($i = 11; $i >= 0; $i--) {
        $month = now()->startOfYear()->addMonths($i);
        if ($month->isFuture()) {
          break;
        }
        $salesLabels[] = $month->format('M');
        $salesData[] = Order::where('status', 'confirmed')
          ->whereYear('created_at', $month->year)
          ->whereMonth('created_at', $month->month)
          ->sum('total');
      }
    } else {
      // Default: 7 months
      for ($i = 6; $i >= 0; $i--) {
        $month = now()->subMonths($i);
        $salesLabels[] = $month->format('M');
        $salesData[] = Order::where('status', 'confirmed')
          ->whereYear('created_at', $month->year)
          ->whereMonth('created_at', $month->month)
          ->sum('total');
      }
    }

    return view('admin-dashboard.index', compact(
      'usersCount',
      'productsCount',
      'ordersCount',
      'totalRevenue',
      'categoryLabels',
      'categoryData',
      'categoryColors',
      'salesLabels',
      'salesData',
      'orders'
    ));
  }
}
