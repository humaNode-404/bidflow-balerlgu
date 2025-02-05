<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class PrValueRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!is_numeric($value)) {
            $fail('The :attribute must be a valid number.');
        }

        if ($value < 1000 || $value > 99000000) {
            $fail('The :attribute must be between 1,000 and 99,000,000.');
        }

        if (!preg_match('/^\d{1,8}(\.\d{1,2})?$/', $value)) {
            $fail('The :attribute must have up to 2 decimal places only.');
        }
    }
}
