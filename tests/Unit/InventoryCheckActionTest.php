<?php

namespace Tests\Unit;

use App\Domain\Inventory\Actions\InventoryCheckAction;
use Tests\InventoryBaseTest;

class InventoryCheckActionTest extends InventoryBaseTest
{
    /**
     * a. Purchased 1 unit at $10 per unit
     * b. Purchased 2 units at $20 per unit
     * c. Purchased 2 units at $15 per unit
     * d. Applied 2 units

     * After the 2 units have been applied, the purchased units in 'a' have been completely used up. Only 1 unit from 'b' has been used, so the remaining inventory looks like this:

     * b. 1 unit at $20 per unit c. 2 units at $15 per unit
     * Quantity on hand = 3 Valuation = (1 * 20) + (2 * 15) = $50
     *
     * @return void
     */
    public function test_inventory_check_action()
    {
        $this->createPurchaseExample();

        $checkAction = new InventoryCheckAction();
        $value = $checkAction->execute(2);

        $this->assertEquals(50, $value);
    }

}
