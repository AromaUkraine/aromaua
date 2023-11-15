<?php

namespace App\Http\Requests;

use App\Rules\MatchOldPassword;
use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'old_password' =>['required', new MatchOldPassword],
            'new_password' =>['required','min:8'],
            'confirm_new_password' =>['same:new_password'],
        ];
    }

    public function messages()
    {
        return [
            'new_password.min'=>__('validation.size.string',['attribute'=>__('cms.new_password'),'size'=>8]),
            'confirm_new_password.same' =>__('validation.same',['attribute'=>__('cms.new_password'),'other'=>__('cms.confirm_new_password')])
        ];
    }
}
