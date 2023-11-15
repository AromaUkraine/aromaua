<?php

namespace App\Http\Requests;

use App\Models\Page;
use App\Models\Template;
use App\Services\LanguageRules;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Factory as ValidationFactory;

class SectionRequest extends CustomFormRequest
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
            'template_id' => ["required", 'main_unique'],

            '%name%' => ["required", "max:255"],
            '%slug%' => ["required", "max:255", 'page_slug_unique'],
            '%h1%' => ["max:255"],
            '%title%' => ["max:255"],
            '%description%' => ["max:255"],
            '%keywords%' => ["max:255"],
            '%breadcrumbs%' => ["max:255"],
            '%anchor%' => ["max:255"],
        ];

        return LanguageRules::make($rules);
    }

    public function messages()
    {
        return [
            'template_id.main_unique' => '"Главная страница" уже создана. Этот раздел может быть только один.',
            'page_slug_unique' => 'Такой url уже существует.'
        ];
    }

    public function withValidator($validator)
    {

        $validator->addExtension('page_slug_unique', function ($attribute, $value, $parameters, $validator) {

            $ex = explode('.', $attribute);
            $locale = array_shift($ex);
            $slug = end($ex);

            // ищу страницу по языку и по slug
            $page = Page::join('page_translations', function ($join) use ($locale, $slug, $value) {
                $join->on('pages.id', '=', 'page_translations.page_id')
                    ->where('locale', $locale)
                    ->where($slug, $value);
            })->first();


            // если существует страница с указаным slug
            if ($page) {

                // если section не создана но указан существующий slug
                if(!request()->section){
                    return false;
                }

                //если id связанного раздела не совпадает с переданным разделом
                if ($page->pageable_id !== request()->section->id) {
                    return false;
                }
            }

            return true;
        });

        //Гглавная страница должна быть только одна
        $validator->addExtension('main_unique', function ($attribute, $value, $parameters, $validator) {
            $template = Template::with('section')->where('is_main', Template::IS_MAIN)->first();

            // шаблон и раздел главная уже существует
            if (isset($template) && isset($template->section[0])) {

                // если section не создана но указан шаблон main
//                if(!request()->section){
//                    return false;
//                }
//
//                // если section существует
//                // если в реквесте указан шаблон главной страницы и section->id не совпадает с template->section->id
//                if (request()->template_id == $template->id && request()->section->id != $template->section[0]->id) {
//                    return false;
//                }
            }

            return true;
        });


//        $validator->addReplacer('page_slug_unique', function ($message, $attribute, $rule, $parameters, $validator) {
//            return __("The :attribute can't be lorem ipsum.", compact('attribute'));
//        });
//        $validator->addReplacer('main_unique', function ($message, $attribute, $rule, $parameters, $validator) {
//            return __("The :attribute can't be lorem ipsum.", compact('attribute'));
//        });
    }

//    public function __construct(ValidationFactory $validationFactory)
//    {
//
//        $validationFactory->extend(
//            'page_slug_unique',
//            function ($attribute, $value, $parameters) {
////                dump($attribute);
////                dump($value);
////                dd($parameters);
////                return 'page_slug_unique' === $value;
//                return true;
//            },
//            'Sorry, it failed foo validation!'
//        );
//
//    }

}
