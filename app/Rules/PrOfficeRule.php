<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Storage;

class PrOfficeRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Load the JSON file
        $officeData = json_decode(Storage::get('offices.json'), true);

        // Calculate valid office IDs as index + 1
        $validOfficeIds = array_map(fn($key) => $key + 1, array_keys($officeData));

        // Check if the given value is in the valid IDs
        if (!in_array($value, $validOfficeIds)) {
            $fail("The selected {$attribute} is invalid.");
        }

    }
}
