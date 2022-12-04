<?php

namespace Tests\Unit;

use App\Domain\Inventory\Actions\InventoryPurchaseAction;
use App\Models\Purchase;
use Tests\TestCase;

class InventoryPurchaseActionTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->withoutExceptionHandling();
    }

    /**
     * Test the purchase functions correctly
     *
     * @return void
     */
    public function test_purchase_action()
    {
        $purchaseAction = new InventoryPurchaseAction();

        $purchase = $purchaseAction->execute(10, 5);

        $this->assertDatabaseHas('purchases', [
            'quantity' => 10,
            'price' => 5.00
        ]);

        $this->assertTrue(get_class($purchase) == Purchase::class, 'Assert that it returns the correct model class');
    }

}
