<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Storage;

class PrModeRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Load the JSON file
        $modes = json_decode(Storage::get('static-data/pr_modes.json'), true);

        // Check if the value is in the valid modes
        if (!in_array($value, $modes)) {
            $fail("The selected :attribute is invalid, value doesn't exist");
        }
    }
}