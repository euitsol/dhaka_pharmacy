<?php

namespace App\Rules\ApiRules;

use App\Models\AddToCart;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class OrderItemStatusCheck implements ValidationRule
{
    public function __construct()
    {
    }
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $cart = AddToCart::where('id', $value)->where('status', 1)->first();
        if (!$cart) {
            $fail('One or more items on your card do not exist.');
        }
        return;
    }
}
