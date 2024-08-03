<?php

namespace App\Rules;

use App\Models\AddToCart;
use App\Models\Medicine;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CartProductRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $product = Medicine::where('slug', $value)->first();
        $user = user();

        $query = AddToCart::query();

        if ($user && $product) {
            if ($query->where('customer_id', $user->id)->where('product_id', $product->id)->where('status', 1)->exists()) {
                $fail('This product is already in your cart!');
            }
        }
        return;
    }
}
