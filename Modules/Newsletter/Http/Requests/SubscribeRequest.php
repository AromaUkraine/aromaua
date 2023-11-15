<?php

namespace Modules\Newsletter\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubscribeRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => ['required', 'string', 'email:rfc,dns', 'max:255', 'unique:newsletters,email,NULL,id,deleted_at,NULL'],
        ];
    }

    public function messages()
    {
        return [
            'email.unique' => __('web.newsletter_email_exist'),
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}