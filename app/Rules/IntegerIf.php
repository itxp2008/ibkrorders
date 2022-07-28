<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Contracts\Validation\DataAwareRule;

class IntegerIf implements Rule, DataAwareRule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */

    protected $data = [], $if;

    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }

    public function __construct($if)
    {
        //
        $this->if = $if;
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
        // dd(boolval($this->data[$this->if]), ($value % 1), 0, $value);

        if($this->data[$this->if])
            if(fmod($value, 1) > 0)
                return false;
        return true;
        // dd($this->data[$this->if], $attribute, $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return "The :attribute must be an integer when {$this->if} is set to Yes";
    }
}