<?php

namespace Tests\Unit;

use App\Domain\Inventory\Actions\InventoryApplicationAction;
use App\Domain\Inventory\Actions\InventoryPurchaseAction;
use App\Domain\Inventory\Exceptions\InventoryUnavailableException;
use App\Models\Application;
use App\Models\Purchase;
use Tests\InventoryBaseTest;

class InventoryApplicationActionTest extends InventoryBaseTest
{
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
     * Test application making sure that applications are consuming partial purchases
     *
     * @return void
     * @throws InventoryUnavailableException
     */
    public function test_application_action_partial_purchases()
    {
        $purchaseAction = new InventoryPurchaseAction();
        $applicationAction = new InventoryApplicationAction();

        $purchase1 = $purchaseAction->execute(20, 20.00);
        $application = $applicationAction->execute(10);

        $purchase2 = $purchaseAction->execute(40, 20.00);
        $application = $applicationAction->execute(20);

        $this->assertDatabaseHas('purchases', [
            'id' => $purchase1->id,
            'quantity' => 20,
            'price' => 20,
            'consumed' => 20
        ]);

        $this->assertDatabaseHas('purchases', [
            'id' => $purchase2->id,
            'quantity' => 40,
            'price' => 20,
            'consumed' => 10
        ]);
    }

    /**
     * Test the application returns false when there are not enough purchases
     * Do I really want this function to handle a case where there is not enough purchases?? This should be handled by the request on input validations
     *
     * @return void
     */
    public function test_application_action_not_enough_purchases()
    {
        $this->withExceptionHandling();

        $this->expectException(InventoryUnavailableException::class);

        $purchaseAction = new InventoryPurchaseAction();
        $purchaseAction->execute(1, 20.00);
        $purchaseAction->execute(1, 15.00);

        $applicationAction = new InventoryApplicationAction();
        $applicationAction->execute(3);
    }

}
