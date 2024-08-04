<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class DurationRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */

    protected $duration;

    public function __construct($duration)
    {
        $this->duration = $duration;
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($this->duration == 30 && $value != 'monthly') {
            $fail('The duration_title must be "monthly" for a duration of 30.');
        } elseif ($this->duration == 182 && $value != 'quarterly') {
            $fail('The duration_title must be "quarterly" for a duration of 182.');
        } elseif ($this->duration == 365 && $value != 'yearly') {
            $fail('The duration_title must be "yearly" for a duration of 365.');
        }
    }
}
