<?php

namespace Tests\Unit;

use App\Domain\Inventory\Actions\InventoryApplicationAction;
use App\Domain\Inventory\Actions\InventoryPurchaseAction;
use App\Models\Application;
use Tests\TestCase;

class InventoryApplicationActionTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->withoutExceptionHandling();
    }

    /**
     * Test the application function across 1 purchase
     *
     * @return void
     */
    public function test_application_action_simple()
    {
        $purchaseAction = new InventoryPurchaseAction();
        $purchaseAction->execute(2, 20.00);

        $applicationAction = new InventoryApplicationAction();

        $application = $applicationAction->execute(1);

        $this->assertDatabaseHas('applications', [
            'id' => $application->id
        ]);

        $this->assertDatabaseHas('purchases', [
            'quantity' => 2,
            'price' => 20,
            'consumed' => 1
        ]);

        $this->assertDatabaseHas('application_purchase', [
            'application_id' => $application->id,
            'purchase_id' => 1,
            'quantity' => 1
        ]);

        $this->assertTrue(get_class($application) == Application::class, 'Assert that it returns the correct model class');
    }

    /**
     * Test the application function across multiple purchases
     *
     * @return void
     */
    public function test_application_action_advanced()
    {
        $purchases = $this->createPurchaseExample();

        $applicationAction = new InventoryApplicationAction();

        $application = $applicationAction->execute(2);

        $this->assertDatabaseHas('purchases', [
            'id' => $purchases[0]->id,
            'quantity' => 1,
            'price' => 10,
            'consumed' => 1
        ]);

        $this->assertDatabaseHas('purchases', [
            'id' => $purchases[1]->id,
            'quantity' => 2,
            'price' => 20,
            'consumed' => 1
        ]);

        $this->assertDatabaseHas('purchases', [
            'id' => $purchases[2]->id,
            'quantity' => 2,
            'price' => 15,
            'consumed' => 0
        ]);

        $this->assertDatabaseHas('application_purchase', [
            'application_id' => $application->id,
            'purchase_id' => $purchases[0]->id,
            'quantity' => 1
        ]);

        $this->assertDatabaseHas('application_purchase', [
            'application_id' => $application->id,
            'purchase_id' => $purchases[1]->id,
            'quantity' => 1
        ]);

    }

    /**
     * Creates the purchase example
     * a. Purchased 1 unit at $10 per unit
     * b. Purchased 2 units at $20 per unit
     * c. Purchased 2 units at $15 per unit
     *
     * @return array
     */
    private function createPurchaseExample(): array
    {
        $purchaseAction = new InventoryPurchaseAction();

        return [
            $purchaseAction->execute(1, 10),
            $purchaseAction->execute(2, 20),
            $purchaseAction->execute(2, 15)
        ];
    }

}
