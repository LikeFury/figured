<?php

namespace App\Domain\Inventory\Actions;

use App\Models\Purchase;

final class InventoryPurchaseAction
{
    /**
     * @param int $quantity
     * @param float $price
     * @return Purchase
     */
    public function execute(int $quantity, float $price): Purchase
    {
        $purchase = new Purchase();
        $purchase->quantity = $quantity;
        $purchase->price = round($price, 2);

        $purchase->save();

        return $purchase;
    }
}
