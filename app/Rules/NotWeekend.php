<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class NotWeekend implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        return !in_array(date('N', strtotime($value)), [6, 7]);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return 'The :attribute must not be a weekend date.';
    }
}
