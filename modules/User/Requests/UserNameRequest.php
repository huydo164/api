<?php

namespace Modules\User\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserNameRequest extends FormRequest
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
        $user = auth()->guard('api')->user();
        $required = !$user ? 'required|' : '';

        return [
            'value' => $required . 'min:5|max:255|unique:users,username,' . ($user->id ?? 0),
        ];
    }
}
