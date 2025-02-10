<?php

namespace App\Rules;

use App\Models\Address;
use Closure;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Validation\ValidationRule;

class AddressBelongsToUser implements ValidationRule
{
    protected $user;

    public function __construct(Authenticatable $user)
    {
        $this->user = $user;
    }
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $address = Address::where('creater_id', $this->user->id)->where('creater_type', get_class($this->user))->first();

        if (!$address) {
            $fail('This address does not belong to the authenticated user.');
        }
    }
}
