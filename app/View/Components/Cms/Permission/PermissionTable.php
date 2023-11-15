<?php


namespace App\View\Components\Cms\Permission;


use Illuminate\View\Component;

class PermissionTable extends Component
{
    public $tableData;
    /**
     * @var \Illuminate\Support\Collection
     */
    private $used;

    /**
     * PermissionTable constructor.
     * @param $data
     */
    public function __construct($data, $used)
    {
        $this->tableData = collect($data);
        $this->used = collect($used);
    }

    /**
     * @return \Closure|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.cms.permission.permission-table');
    }

    public function setActionName($action)
    {
        if($action){
            $name = \Str::afterLast($action,'.');
            return __('cms.action_'.$name);
        }else{
            return null;
        }
    }


    public function checkSelected($action): bool
    {
        if($action) :
            return (bool)$this->used->where('slug', $action)->first();
        endif;

        return false;
    }
}
