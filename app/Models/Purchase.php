<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    /**
     * Scope available purchases
     * @param $query
     * @return mixed
     */
    public function scopeAvailable($query)
    {
        return $query->whereRaw('consumed < quantity');
    }

    /**
     * Get the total available purchases
     * @return int
     */
    static public function totalAvailable(): int
    {
        $purchases = Purchase::available()->get();

        $totalQuantity = $purchases->pluck('quantity')->sum();
        $totalConsumed = $purchases->pluck('consumed')->sum();

        return $totalQuantity - $totalConsumed;
    }
}
