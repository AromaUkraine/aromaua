<?php


namespace Modules\Developer\Http\Controllers;


use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\PageComponent;
use Modules\Developer\Entities\Template;
use Modules\Developer\Http\Requests\MakeWidgetRequest;

class MakeWidgetController extends Controller
{

    public function create(Page $page)
    {

        $alias = $page->data['alias'];
        $pages = Page::all()->filter(function ($p) use ($alias) {
            return $p->data['alias'] != $alias;
        });

        $data = [
            "name" => "Набор сущностей",
            "description" => "Отображение отобраных сущностей для показа на какой-либо странице в виде блока (например новинки товара, последние новости и т.д.)",
            "alias" => $alias,
            "type" => "widget",
            "cms_navigation" => [
                "label" => "cms.product_list",
                "icon" => "",
                "slug" => "module.add_entities_on_page.index"
            ]
        ];

        return view('developer::make_widget.create', compact('page', 'pages', 'data', 'alias'));
    }


    public function store(MakeWidgetRequest $request, Page $page)
    {

        try {
            \DB::beginTransaction();

            $add_to_page = Page::findOrFail($request->page_id);
            $cms_navigation = json_decode($request->data['cms_navigation'], true);
            $data = [
                'name' => $request->name,
                'alias' => $request->alias,
                'description' => $request->description,
                'type' => $request->type,
                'data' => [
                    'cms_navigation' => [$cms_navigation]
                ],
            ];

            // update template
            $template_data['components'] = array_merge($add_to_page->pageable->data['components'], [$data]);
            $add_to_page->pageable->update(['data' => $template_data]);

            // create page component
            $add_to_page->components()->create($data);

            \DB::commit();
        } catch (\Exception $e) {

            \DB::rollback();
            dd('Update failed with class "' . get_class($this) . '" error : ' . $e->getMessage());
        }



        return redirect(route('developer.template.index'));


//        $test_data = [
//            'components' => [
//                [
//                    "name" => "Основной баннер",
//                    "alias" => "banner-main",
//                    "type" => "widget",
//                    "description" => "Создание баннеров, слайдеров",
//                    "data" => [
//                        "cms_navigation" => [
//                            "label" => "cms.banner",
//                            "icon" => "",
//                            "slug" => "module.page_banner.index"
//                        ]
//                    ]
//                ]
//            ]
//        ];
//
//        $add_to_page->pageable->update(['data'=>$test_data]);


    }
}
