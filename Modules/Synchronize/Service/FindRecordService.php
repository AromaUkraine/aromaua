<?php


namespace Modules\Synchronize\Service;


use Modules\Catalog\Entities\PriceType;
use Modules\Catalog\Entities\Product;

class FindRecordService
{

    public function findProductByCodes($kod_katochki_price, $kod_kartochki_nomenklature)
    {
        return Product::where('card_code', $kod_katochki_price)
            ->where('code', $kod_kartochki_nomenklature)
            ->first();
    }

    public function findPriceTypeBySeria($seria)
    {
        if (empty($seria))
            $seria = null;

        return PriceType::where('key', $seria)->first();
    }
}
