<?php

namespace App\Http\Requests;

use App\Models\User;
use App\Rules\AccountBalanceEnoughRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TransactionStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'recipient' => [
                'required',
                'integer',
                Rule::exists(with(new User())->getTable(), 'id')->where(function ($query) {
                    $query->where('id', '!=', auth()->id());
                }),
            ],
            'amount' => [
                'required',
                'numeric',
                'min:0.01',
                new AccountBalanceEnoughRule()
            ],
            'date' => 'required|date|afterTodayWithHours:time',
            'time' => 'required|integer|min:0|max:23',
        ];
    }
}
