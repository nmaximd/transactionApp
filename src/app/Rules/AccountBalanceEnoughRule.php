<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class AccountBalanceEnoughRule implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $user =auth()->user();
        return $user->account && $user->account->balance >= (float)$value;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('There is not enough money on your balance.');
    }
}
