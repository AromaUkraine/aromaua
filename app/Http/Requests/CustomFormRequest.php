<?php


namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;

class CustomFormRequest extends FormRequest
{

    public function withValidator($validator)
    {
        if($validator->fails()){
            toastr()->error(__('toastr.validation_error.message'), __('toastr.validation_error.title'));
        }
    }
}
