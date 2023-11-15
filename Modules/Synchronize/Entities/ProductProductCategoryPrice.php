<?php

namespace Modules\Synchronize\Entities;

use App\Traits\JsonDataTrait;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Modules\Synchronize\Entities\ProductProductCategoryPriceTranslation;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;

class ProductProductCategoryPrice extends Model implements TranslatableContract
{

    // use Cachable;

    use Translatable;


    protected $fillable = [
        'product_category_id',
        'product_id',
        'series',
        'column_number',
        'min',
        'max',
        'price_list',
        'order',
        'active'
    ];

    public $timestamps = false;

    protected $dates = ['deleted_at'];

    public $translatedAttributes = ['column_name', 'text', 'price', 'currency', 'data'];


    public function getTranslationModelName(): string
    {
        return ProductProductCategoryPriceTranslation::class;
    }


    public function product()
    {
        return $this->belongsTo(Product::class);
    }


    public function category()
    {
        return $this->belongsTo(ProductCategory::class);
    }


    // Автоматическое увеличение счетчика order
    protected static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $model->order = self::max('order') + 1;
        });
    }


    /**
     * Декодирует аттрибут price_list когда к нему обращаются
     * @param $value
     * @return mixed
     */
    public function getPriceListAttribute($value)
    {
        return json_decode($value, true);
    }

    /**
     * Кодирует аттрибут price_list перед сохранением
     * @param $value
     */
    public function setPriceListAttribute($value)
    {
        $this->attributes['price_list'] = json_encode($value, JSON_UNESCAPED_UNICODE);
    }
}
