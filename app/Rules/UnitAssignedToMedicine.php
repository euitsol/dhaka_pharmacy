<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use App\Models\Medicine;

class UnitAssignedToMedicine implements ValidationRule
{
    private $medicineSlug;

    public function __construct($medicineSlug)
    {
        $this->medicineSlug = $medicineSlug;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $medicine = Medicine::with('units')->where('slug', $this->medicineSlug)->first();

        if (!$medicine) {
            $fail('The selected medicine does not exist.');
            return;
        }

        if (!$medicine->units()->where('medicine_units.id', $value)->exists()) {
            $fail('The selected unit is not associated with the specified medicine.');
        }
    }
}
