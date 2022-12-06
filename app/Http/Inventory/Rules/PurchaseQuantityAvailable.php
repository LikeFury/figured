<?php

namespace App\Http\Inventory\Rules;

use App\Models\Purchase;
use Illuminate\Contracts\Validation\InvokableRule;

class PurchaseQuantityAvailable implements InvokableRule
{
    /**
     * Run the validation rule.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     * @return void
     */
    public function __invoke($attribute, $value, $fail)
    {
        if (Purchase::totalAvailable() < $value) {
            $fail('There is not enough quantity to fulfill request');
        }
    }
}
