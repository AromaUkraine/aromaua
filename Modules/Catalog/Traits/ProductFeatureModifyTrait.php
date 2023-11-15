<?php


namespace Modules\Catalog\Traits;


use Modules\Catalog\Entities\Product;

trait ProductFeatureModifyTrait
{

    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_product_id')
            ->where('parent_product_id', '!=', $this->id);
    }

    // все сзязанные с товаром товары включая самого себя
    public function related()
    {
        return $this->hasMany(self::class, 'parent_product_id')
            ->where('parent_product_id', $this->id);
    }

    // все сзязанные с товаром товары исключая самого себя
    public function children()
    {
        return $this->related()->where('id', '!=', $this->id);
    }



    /***
     Не испоьзовать!!! Ссылается на самого себя (нужен исключительно для подключения модификации и удаления товара)
     ***/
    public function feature_modify()
    {
        return $this->hasMany(self::class, 'id','parent_product_id');
    }
}
