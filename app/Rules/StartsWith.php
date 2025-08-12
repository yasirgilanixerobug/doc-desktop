<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class StartsWith implements Rule
{
    protected $prefix;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($prefix)
    {
        $this->prefix = $prefix;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return strpos($value, $this->prefix) === 0;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute must start with ' . $this->prefix . '.';
    }
}
