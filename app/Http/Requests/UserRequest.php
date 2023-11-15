<?php

namespace App\Http\Requests;

use App\Models\User;



class UserRequest extends CustomFormRequest
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

        $rules = [
            "login" =>["required","max:255", 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            "role_id"=>["required"],
        ];

        if($this->method() === "POST"){
            $rules["password"] = ['required', 'string', 'min:8', 'confirmed'];
        }

        if($this->method() === "PATCH" ){
            $user = User::findOrFail((int) request()->administration->id);
            $rules["login"] = ["required","max:255", 'unique:users,login,'.$user->id];
            $rules["email"] = ["required",'string',"max:255","email","unique:users,email,".$user->id];
        }

        return $rules;
    }

}
