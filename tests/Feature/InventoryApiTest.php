<?php

namespace Tests\Feature;

use Tests\InventoryBaseTest;

class InventoryApiTest extends InventoryBaseTest
{
    /**
     * Test the purchase functions correctly
     *
     * @return void
     */
    public function test_inventory_api_valid()
    {
        $this->createPurchaseExample();

        $response = $this->postJson('/api/inventory', [
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
     * Test checking not enough purchases available
     */
    public function test_inventory_api_not_enough_stock()
    {
        $this->createPurchaseExample();

        $response = $this->postJson('/api/inventory', [
            'quantity' => 6
        ]);

        $response->assertStatus(422);

    }

}
