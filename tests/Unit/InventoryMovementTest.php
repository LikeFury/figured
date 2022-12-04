<?php

namespace Tests\Unit;

use App\Domain\Inventory\Actions\InventoryPurchaseAction;
use Tests\TestCase;

class InventoryMovementTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_purchase_action()
    {
        $purchaseAction = new InventoryPurchaseAction();

        $purchaseAction->execute(10, 5);

        $this->assertDatabaseHas('purchases', [
            'quantity' => 10,
            'price' => 5.00
        ]);
    }
}
