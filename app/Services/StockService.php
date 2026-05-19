<?php

namespace App\Services;

use App\Models\Stock;
use Illuminate\Validation\ValidationException;

class StockService
{
    public function availableQty(int $stockId): int
    {
        return (int) (Stock::query()->whereKey($stockId)->value('quantity') ?? 0);
    }

    public function assertAvailable(int $stockId, int $requestedQty): void
    {
        $available = $this->availableQty($stockId);

        if ($requestedQty > $available) {
            throw ValidationException::withMessages([
                'qty' => "The demanded quantity not available. Available: {$available}",
            ]);
        }
    }

    public function deductOrFail(int $stockId, int $qty): void
    {
        $stock = Stock::query()
            ->whereKey($stockId)
            ->lockForUpdate()
            ->first();

        $available = (int) ($stock?->quantity ?? 0);

        if ($qty > $available) {
            throw ValidationException::withMessages([
                'qty' => "The demanded quantity not available. Available: {$available}",
            ]);
        }

        $stock->quantity = $available - $qty;
        $stock->save();
    }
}
