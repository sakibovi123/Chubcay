<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class MonthYear implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail):void
    {
        // Define the regular expression pattern to match mm-yyyy or mm/yyyy
        $pattern = '/^(0[1-9]|1[0-2])\/(\d{2})$/';

        // Check if the value matches the pattern
        if (!preg_match($pattern, $value)) {
            $fail('The :attribute must be in the format mm-yy or mm/yy.');
        }
    }
}
