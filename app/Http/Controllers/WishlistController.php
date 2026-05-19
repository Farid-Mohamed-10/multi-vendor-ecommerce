<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
  public function index()
  {
    $wishlists = Auth::user()->wishlists()->with('product.stocks')->latest()->paginate(12);

    $view = Auth::user()->hasRole('admin') ? 'admin-dashboard.wishlist.index' : 'buyer-dashboard.wishlist.index';

    return view($view, compact('wishlists'));
  }

  public function toggle(Product $product)
  {
    $existing = Wishlist::where('user_id', Auth::id())
      ->where('product_id', $product->id)
      ->first();

    if ($existing) {
      $existing->delete();
      return redirect()->back()->with('success', 'Removed from wishlist.');
    }

    Wishlist::create([
      'user_id'    => Auth::id(),
      'product_id' => $product->id,
    ]);

    return redirect()->back()->with('success', 'Added to wishlist!');
  }

  public function destroy(Wishlist $wishlist)
  {
    abort_if($wishlist->user_id !== Auth::id(), 403);
    $wishlist->delete();
    return redirect()->back()->with('success', 'Removed from wishlist.');
  }
}
