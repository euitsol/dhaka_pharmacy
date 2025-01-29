<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use App\Models\AddToCart;
use App\Models\Medicine;

class CartMedicineUnitRule implements ValidationRule
{
    private $cart_id;

    public function __construct($cart_id)
    {
        $this->cart_id = $cart_id;
    }
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $cart = AddToCart::where('id', $this->cart_id)->first();

        if (!$cart) {
            $fail('The selected cart does not belong to the user or does not exist.');
            return;
        }

        $medicineId = $cart->product_id;

        $medicine = Medicine::with('units')->find($medicineId);

        if (!$medicine || !$medicine->units()->where('medicine_units.id', $value)->exists()) {
            $fail('The selected unit is not associated with the medicine in the cart.');
        }
    }
}
