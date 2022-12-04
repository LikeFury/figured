<?php

namespace App\Domain\Inventory\Actions;

use App\Models\Purchase;

final class InventoryCheckAction
{
    /**
     * Check inventory and return the total price or false
     *
     * @param int $quantity
     * @return float|bool
     */
    public function execute(int $quantity): float | bool
    {
        if (Purchase::totalAvailable() < $quantity) {
            return false;
        }

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
