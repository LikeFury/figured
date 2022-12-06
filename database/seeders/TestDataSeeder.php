<?php

namespace Database\Seeders;

use App\Domain\Inventory\Actions\InventoryApplicationAction;
use App\Domain\Inventory\Actions\InventoryPurchaseAction;
use App\Models\Purchase;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TestDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(InventoryPurchaseAction $purchaseAction, InventoryApplicationAction $applicationAction)
    {

        $exampleData = json_decode(file_get_contents(storage_path('json/example.json')), true);

        foreach ($exampleData as $data) {

            if ($data['Type'] == 'Purchase') {
                $purchaseAction->execute($data['Quantity'], $data['Unit Price']);
            } else {
                $applicationAction->execute(0 - $data['Quantity']);
            }

        }

    }
}
