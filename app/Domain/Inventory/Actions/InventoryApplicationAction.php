<?php

namespace App\Domain\Inventory\Actions;

use App\Models\Application;
use App\Models\Purchase;

final class InventoryApplicationAction
{
    public function execute(int $quantity): Application
    {
        $application = new Application();
        $application->save();

        $purchases = Purchase::where('consumed', '<', 'quantity')->get();

        foreach ($purchases as $purchase)
        {
            $purchase->consumed = $purchase->quantity - $quantity;
            $purchase->save();

            $application->purchases()->attach($purchase, [
                'quantity' => $quantity
            ]);
        }

        return $application;
    }
}
