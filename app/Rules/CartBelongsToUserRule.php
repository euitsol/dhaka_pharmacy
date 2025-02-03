<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use App\Models\AddToCart;

class CartBelongsToUserRule implements ValidationRule
{
    protected $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $cart = AddToCart::where('id', $value)->where('customer_id', $this->user->id)->first();

        if (!$cart) {
            $fail('This cart item does not belong to the authenticated user.');
        }
    }
}
