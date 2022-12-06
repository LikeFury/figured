<?php

namespace App\Http\Inventory\Controllers;

use App\Domain\Inventory\Actions\InventoryCheckAction;
use App\Http\Base\Controllers\Controller;
use App\Http\Inventory\Requests\InventoryCheckRequest;
use App\Http\Inventory\Resources\InventoryCheckResource;

class InventoryController extends Controller
{
    /**
     * Check inventory availability
     *
     * @param InventoryCheckRequest $request
     * @param InventoryCheckAction $inventoryCheckAction
     * @return InventoryCheckResource
     */
    public function check(InventoryCheckRequest $request, InventoryCheckAction $inventoryCheckAction)
    {
        $value = $inventoryCheckAction->execute($request->validated('quantity'));

        return new InventoryCheckResource(['value' => $value]);
    }
}
