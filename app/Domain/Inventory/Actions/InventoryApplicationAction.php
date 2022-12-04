<?php

namespace App\Domain\Inventory\Actions;

use App\Models\Application;
use App\Models\Purchase;

final class InventoryApplicationAction
{
    /**
     * Create an application, its relationship to purchase and update the purchase consumed columns
     * @param int $requestQuantity
     * @return Application
     */
    public function execute(int $requestQuantity): Application
    {
        $application = new Application();
        $application->save();

        $this->processPurchases($application, $requestQuantity);

        return $application;
    }

    /**
     * Loop through valid purchases and calculate how many we will consume of each
     * @param Application $application
     * @param int $requestQuantity
     * @return void
     */
    private function processPurchases(Application $application, int $requestQuantity)
    {
        $purchases = Purchase::where('consumed', '<', 'quantity')->get();

        foreach ($purchases as $purchase) {

            // Exit the loop if there is no more to do, saves on DB queries
            if ($requestQuantity == 0) continue;

            $consumedQuantity = $this->calculateConsumedQuantity($purchase, $requestQuantity);

            $requestQuantity -= $consumedQuantity;

            $this->savePurchaseAndEstablishRelationship($application, $purchase, $consumedQuantity);
        }
    }

    /**
     * Calculate the purchase consumed amount off the given request quantity
     * @param Purchase $purchase
     * @param int $requestQuantity
     * @return int
     */
    private function calculateConsumedQuantity(Purchase $purchase, int $requestQuantity): int
    {
        if ($requestQuantity > $purchase->quantity) {
            $consumedQuantity = $requestQuantity - $purchase->quantity;
        } else {
            $consumedQuantity = $purchase->quantity - $requestQuantity;
        }

        return $consumedQuantity;
    }

    /**
     * Establish the relationship between the application and purchase with the quantity
     * @param Application $application
     * @param Purchase $purchase
     * @return void
     */
    private function savePurchaseAndEstablishRelationship(Application $application, Purchase $purchase, int $consumedQuantity): void
    {
        $purchase->consumed = $consumedQuantity;
        $purchase->save();

        $application->purchases()->attach($purchase, [
            'quantity' => $consumedQuantity
        ]);
    }
}
