<?php


namespace Modules\Banner\DataTables;


use App\Traits\DataTableTrait;
use App\View\Components\Cms\Buttons\DataTableButton;
use Modules\Banner\Entities\Banner;
use Yajra\DataTables\Services\DataTable;

class PageEntityBannerDataTable  extends EntityBannerDataTable
{

    protected function getActionColumn($data)
    {
        $buttons = null;




        return $buttons;
    }
}
