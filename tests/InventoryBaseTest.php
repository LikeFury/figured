<?php

namespace Tests;

use App\Domain\Inventory\Actions\InventoryPurchaseAction;

class InventoryBaseTest extends TestCase
{
    /**
     * Creates the purchase example
     * a. Purchased 1 unit at $10 per unit
     * b. Purchased 2 units at $20 per unit
     * c. Purchased 2 units at $15 per unit
     *
     * @return array
     */
    protected function createPurchaseExample(): array
    {
        $purchaseAction = new InventoryPurchaseAction();

        return [
            $purchaseAction->execute(1, 10),
            $purchaseAction->execute(2, 20),
            $purchaseAction->execute(2, 15)
        ];
    }

}
