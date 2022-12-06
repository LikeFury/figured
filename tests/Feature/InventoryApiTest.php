<?php

namespace Tests\Feature;

use Tests\InventoryBaseTest;

class InventoryApiTest extends InventoryBaseTest
{
    public function setUp(): void
    {
        parent::setUp();
        $this->withExceptionHandling();
    }

    /**
     * Test the purchase functions correctly
     *
     * @return void
     */
    public function test_inventory_api_valid()
    {
        $this->createPurchaseExample();

        $response = $this->postJson('/api/inventory/check', [
            'quantity' => 3
        ]);

        $response->assertStatus(200);

        $response->assertJson([
            'data' => [
                'value' => 50
            ]
        ]);
    }

    /**
     * Make sure quantity is a number
     *
     * @return void
     */
    public function test_inventory_api_invalid_quantity()
    {
        $response = $this->postJson('/api/inventory/check', [
            'quantity' => 'STRING'
        ]);

        $response->assertStatus(422);
    }

    /**
     * Make sure quantity is required
     *
     * @return void
     */
    public function test_inventory_api_no_quantity()
    {
        $response = $this->postJson('/api/inventory/check', []);

        $response->assertStatus(422);
    }

    /**
     * Test checking not enough purchases available
     *
     * @return void
     */
    public function test_inventory_api_not_enough_stock()
    {
        $this->createPurchaseExample();

        $response = $this->postJson('/api/inventory/check', [
            'quantity' => 6
        ]);

        $response->assertStatus(422);

        $response->assertJson([
            'message' => 'There is not enough quantity to fulfill request',
        ]);
    }

}
