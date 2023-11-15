<?php


namespace App\View\Components\Cms\Nav;


use App\Models\EntityComponent;
use Illuminate\View\Component;

class NavBrand extends NavConstructor
{


    /**
     * создает меню внутри модуля, виджета их собственных под-меню
     * (например у статьи добавляет пункт галерея самой этой статьи)
     */
    protected function setEntityMenu()
    {
        // убрал хар-тики из меню, так как они добавлены в редактировании самого бренда
        $entity_components = EntityComponent::where('table',$this->entity->getTable())->get()->filter(function ($item){
            return $item->slug != 'module.seo_catalog_feature.index';
        });


        $this->getEntityDefaultItem($entity_components->first());
        $entity_components = $entity_components->toArray();

        // если не переданна страница
        if(!$this->page && $this->entity) :
            $params = ['table'=>$this->entity->getTable(), 'id'=>$this->entity->id ];
        else :
            $params = [ 'page'=>$this->page->id, 'table'=>$this->entity->getTable(), 'id'=>$this->entity->id ];
        endif;

        // создараем пункты меню
        foreach ($entity_components as $item) :
            foreach ($item as $key=>$value):
                $this->entity_menu[$item['slug']]['params'] = $params;
                $this->entity_menu[$item['slug']][$key] = $value;
            endforeach;
        endforeach;
    }

    public function getActive($slug, $params=[])
    {

        if('catalog.seo_catalog.edit' == $slug){
            return  'active';
        }
        return '';
    }
    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return parent::render();
    }
}
