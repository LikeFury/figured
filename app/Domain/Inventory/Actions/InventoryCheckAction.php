<?php

namespace App\Domain\Inventory\Actions;

use App\Models\Purchase;

final class InventoryCheckAction
{
    public function execute(int $quantity): float
    {

        $purchases = Purchase::available()->get();

        $price = 0;
        foreach ($purchases as $purchase) {

            if ($quantity == 0) return $price;

            $availableQuantity = $purchase->quantity - $purchase->consumed;

            if ($quantity > $availableQuantity) {
                $quantity = $quantity - $availableQuantity;
                $price += $availableQuantity * $purchase->price;
            } else {
                $quantity = 0;
                $price += ($availableQuantity - $quantity) * $purchase->price;
            }

        }

        return $price;
    }

}
