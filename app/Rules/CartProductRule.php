<?php

namespace App\Rules;

use App\Models\AddToCart;
use App\Models\Medicine;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CartProductRule implements ValidationRule
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
        $product = Medicine::where('slug', $value)->first();

        if (!$product) {
            return; // Product existence will already be validated by 'exists' in the request rules
        }

        $exists = AddToCart::where('customer_id', $this->user->id)
            ->where('product_id', $product->id)
            ->exists();

        if ($exists) {
            $fail('This product is already in your cart!');
        }
    }
}
