<?php

namespace App\Domain\Inventory\Actions;

use App\Models\Application;
use App\Models\Purchase;

final class InventoryApplicationAction
{
    public function execute(int $requestQuantity): Application
    {
        $application = new Application();
        $application->save();

        $purchases = Purchase::where('consumed', '<', 'quantity')->get();

        foreach ($purchases as $purchase) {

            // Exit the loop if there is no more to do, saves on DB queries
            if ($requestQuantity == 0) continue;

            if ($requestQuantity > $purchase->quantity) {
                $consumedQuantity = $requestQuantity - $purchase->quantity;
            } else {
                $consumedQuantity = $purchase->quantity - $requestQuantity;
            }

            $requestQuantity -= $consumedQuantity;
            $purchase->consumed = $consumedQuantity;
            $purchase->save();

            $application->purchases()->attach($purchase, [
                'quantity' => $consumedQuantity
            ]);
        }

        return $application;
    }
}
