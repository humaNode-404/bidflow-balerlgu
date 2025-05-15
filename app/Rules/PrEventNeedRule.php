<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class PrEventNeedRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Get today's date
        $today = now();

        // Get the minimum date (1 week from today)
        $minDate = $today->copy()->addWeek();

        // Get the maximum date (6 months from today)
        $maxDate = $today->copy()->addMonths(6);

        // Parse the value into a date object
        $selectedDate = \Carbon\Carbon::parse($value);

        // Check if the date is less than 1 week from today
        if ($selectedDate->lt($minDate)) {
            $fail("The :attribute must be at least 1 week from today.");
        }

        // Check if the date exceeds the max range
        if ($selectedDate->gt($maxDate)) {
            $fail("The :attribute must not be more than 6 months from today.");
        }
    }
}
