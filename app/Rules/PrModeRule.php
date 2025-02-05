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
        $modes = json_decode(Storage::get('pr_modes.json'), true);

        // Get the valid keys (mode names)
        $validModes = array_keys($modes);

        // Check if the value is in the valid modes
        if (!in_array($value, $validModes)) {
            $fail("The selected :attribute is invalid, value doesn't exist");
        }
    }
}
