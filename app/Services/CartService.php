<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Stock;

class CartService
{
  private string $key = 'cart.items';

  public function items(): array
  {
    return session()->get($this->key, []);
  }

  public function qtyInCartForStock(int $stockId): int
  {
    $items = $this->items();
    return (int) ($items[(string) $stockId]['qty'] ?? 0);
  }

  public function addStock(Product $product, Stock $stock, int $qty): void
  {
    $qty = max(1, $qty);

    $items = $this->items();
    $key = (string) $stock->id;

    // Snapshot (لكن هنراجع السعر تاني في checkout)
    $price = (float) $product->price;

    if (isset($items[$key])) {
      $items[$key]['qty'] += $qty;
    } else {
      $items[$key] = [
        'stock_id' => $stock->id,
        'product_id' => $product->id,
        'name' => $product->name,
        'slug' => $product->slug,
        'image' => $product->image,
        'price' => $price,
        'qty' => $qty,
        'size' => $stock->size,
        'color' => $stock->color,
      ];
    }

    session()->put($this->key, $items);
  }

  public function updateQty(int $stockId, int $qty): void
  {
    $items = $this->items();
    $key = (string) $stockId;

    if (! isset($items[$key])) {
      return;
    }

    if ($qty <= 0) {
      unset($items[$key]);
    } else {
      $items[$key]['qty'] = $qty;
    }

    session()->put($this->key, $items);
  }

  public function remove(int $stockId): void
  {
    $items = $this->items();
    unset($items[(string) $stockId]);
    session()->put($this->key, $items);
  }

  public function clear(): void
  {
    session()->forget($this->key);
  }

  public function count(): int
  {
    return (int) collect($this->items())->sum('qty');
  }

  public function subtotal(): float
  {
    return (float) collect($this->items())->sum(fn($i) => $i['price'] * $i['qty']);
  }
}
