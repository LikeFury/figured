<?php

namespace Tests\Unit;

use App\Domain\Inventory\Actions\InventoryPurchaseAction;
use App\Models\Purchase;
use Tests\TestCase;

class InventoryMovementTest extends TestCase
{
    /**
     * Test the purchase functions correctly
     *
     * @return void
     */
    public function test_purchase_action()
    {
        $this->withoutExceptionHandling();

        $purchaseAction = new InventoryPurchaseAction();

        $purchase = $purchaseAction->execute(10, 5);

        $this->assertDatabaseHas('purchases', [
            'quantity' => 10,
            'price' => 5.00
        ]);

        $this->assertTrue(get_class($purchase) == Purchase::class, 'Assert that it returns the correct model class');
    }
}
