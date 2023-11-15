<?php

namespace Modules\Synchronize\Entities;

use App\Traits\Sortable;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Synchronize\Entities\ProductDocumentTranslation;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;

class ProductDocument extends Model implements TranslatableContract
{

     // Трейт для "мягкого удаления"
    use SoftDeletes;

    // Трейт для переводов
    use Translatable;

    // Трейт для сортировки
    use Sortable;

    // Трейт для автоматического кеширования
    // use Cachable;



    protected $fillable = ['product_id', 'column_number', 'serial_number', 'order', 'active'];

    public $translatedAttributes = ['name', 'href', 'date', 'publish'];

    public $timestamps = false;

    protected $dates = ['deleted_at'];


    public function getTranslationModelName(): string
    {
        return ProductDocumentTranslation::class;
    }


    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
