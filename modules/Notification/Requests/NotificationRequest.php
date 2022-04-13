<?php

namespace Modules\Notification\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NotificationRequest extends FormRequest
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
        $required = !$this->notification ? 'required|' : '';

        return [
            'user_id' => $required . 'integer',
            'title' => $required,
            'content' => $required,
        ];
    }
}
