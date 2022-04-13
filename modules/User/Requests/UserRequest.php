<?php

namespace Modules\User\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $required = !$this->user ? 'required|' : '';

        return [
            'business_type' => $required . 'integer',
            'business_stage' => $required . 'integer',
            'company_size' => $required . 'integer',
            'company_name' => $required . 'max:255',
            'founding_date' => $required . 'integer',
            'start_tax_settlement' => $required . 'integer',
            'end_tax_settlement' => $required . 'integer',
            'email' => $required . 'max:255|email|unique:users,email,' . ($this->user->id ?? 0),
            'password' => $required . 'min:8|max:255|confirmed|regex:/^(?=.*[a-z])(?=.*\d)[a-z\d]*$/u',
        ];
    }

    /**
     * Get the validation messages.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'email.unique' => 'このメールアドレスは使用できません。別のメールアドレスを選択してください。',
        ];
    }
}
