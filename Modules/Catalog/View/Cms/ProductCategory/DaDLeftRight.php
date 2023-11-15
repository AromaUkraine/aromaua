<?php



namespace Modules\Catalog\View\Cms\ProductCategory;

use Illuminate\View\Component;
use Modules\Catalog\Entities\Feature;

class DaDLeftRight extends Component
{
    /**
     * @var \Illuminate\Database\Eloquent\Collection|Feature[]
     */
    public $used;


    /**
     * @var \Illuminate\Database\Eloquent\Collection|Feature[]
     */
    public $available;
    /**
     * @var mixed|null
     */
    public $options;
    /**
     * @var array|mixed
     */
    public $fixed;

    /**
     * CategoryDaDLeftRight constructor.
     * @param object|null $model
     * @param string|null $options
     */
    public function __construct(?object $model = null, ?string $options=null)
    {
        $used = collect();

        if($model && $model->entity_features->count()) :
            $ids = $model->entity_features->pluck('feature_id');
            $used = Feature::whereIn('id', $ids)->get();
            $available = Feature::whereNotIn('id', $ids)->get();
        else:
            $available = Feature::all();
        endif;

        $this->used = $this->makeItems($used);
        $this->available = $this->makeItems($available);

        $this->options = ($options) ? json_decode($options, true) : null;

        $this->fixed = $this->options['fixed'] ?? [];

    }


    public function addOptions()
    {
        foreach ($this->options as $key=>$value) {
            return "$key=>$value";
        }
    }
    /**
     * @param $items
     * @return mixed
     */
    private function makeItems($items)
    {
        return $items->map( function ($item){
            return [
                'feature_id'=>$item->id,
                'name'=>$item->name
            ];
        });
    }

    /**
     * @return \Closure|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|string
     */
    public function render()
    {
        return view('catalog::cms.components.product_category.dad-left-right');
    }
}
