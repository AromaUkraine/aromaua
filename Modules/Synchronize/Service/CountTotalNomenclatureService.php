<?php


namespace Modules\Synchronize\Service;


class CountTotalNomenclatureService
{
    public function count($nomenclatures)
    {
        $nomenclatures->each(function ($items) use( &$total ) {
            $count = is_array($items) ? count($items): 0;
            $total += $count;
        });

        return $total;
    }
}
