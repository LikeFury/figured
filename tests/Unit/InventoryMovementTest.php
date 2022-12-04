<?php

namespace Tests\Unit;

use App\Domain\Inventory\Actions\InventoryApplicationAction;
use App\Domain\Inventory\Actions\InventoryPurchaseAction;
use App\Models\Application;
use App\Models\Purchase;
use Tests\TestCase;

class InventoryMovementTest extends TestCase
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

    /**
     * Test the application function
     *
     * @return void
     */
    public function test_application_action_avaliable_purchases_simple()
    {
        $purchaseAction = new InventoryPurchaseAction();
        $purchaseAction->execute(2, 20);

        $applicationAction = new InventoryApplicationAction();

        $application = $applicationAction->execute(1);

        $this->assertDatabaseHas('applications', [
            'id' => $application->id
        ]);

        $this->assertDatabaseHas('purchases', [
            'quantity' => 2,
            'price' => 2,
            'consumed' => 1
        ]);

        $this->assertDatabaseHas('applications_purchases', [
            'application_id' => $application->id,
            'purchase_id' => 1,
            'quantity' => 1
        ]);

        $this->assertTrue(get_class($application) == Application::class, 'Assert that it returns the correct model class');
    }

    /**
     * Creates the purchase example
     * a. Purchased 1 unit at $10 per unit
     * b. Purchased 2 units at $20 per unit
     * c. Purchased 2 units at $15 per unit
     *
     * @return void
     */
    private function createPurchaseExample()
    {
        $purchaseAction = new InventoryPurchaseAction();

        $purchaseAction->execute(1, 10);
        $purchaseAction->execute(2, 20);
        $purchaseAction->execute(2, 15);
    }

}
