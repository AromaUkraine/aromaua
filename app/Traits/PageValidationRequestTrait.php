<?php


namespace App\Traits;


use App\Rules\SlugUnique;
use App\Services\LanguageRules;

trait PageValidationRequestTrait
{

    public function call( $model=null ,$rules=[])
    {
        $page_rules = array_merge([
            '%name%' => ["required", "max:255"],
            '%slug%' => ["required", "max:255", new SlugUnique($model)],
        ], $rules);

        return LanguageRules::make($page_rules);
    }


    public function withValidator($validator)
    {
        if($validator->fails()){
            toastr()->error(__('toastr.validation_error.message'), __('toastr.validation_error.title'));
        }
    }
}
