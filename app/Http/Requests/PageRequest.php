<?php

namespace App\Http\Requests;

use App\Models\Page;

use App\Rules\SlugUnique;
use App\Services\LanguageRules;
use App\Traits\PageValidationRequestTrait;
use Illuminate\Foundation\Http\FormRequest;


class PageRequest extends FormRequest
{

    use PageValidationRequestTrait;


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules( )
    {
        return $this->call(request()->page,[]);
    }



}
