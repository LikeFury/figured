<?php

namespace App\Http\Inventory\Requests;

use App\Http\Inventory\Rules\PurchaseQuantityAvailable;
use Illuminate\Foundation\Http\FormRequest;

class InventoryCheckRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'quantity' => ['required', 'integer', new PurchaseQuantityAvailable]
        ];
    }
}
