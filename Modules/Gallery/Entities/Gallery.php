<?php

namespace Modules\Gallery\Entities;

use App\Scopes\OrderScope;
use App\Traits\QueryTrait;
use App\Traits\Sortable;
use App\Traits\ThumbsTrait;
use App\Traits\WidgetTrait;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Venturecraft\Revisionable\RevisionableTrait;

/**
 * Modules\Gallery\Entities\Gallery
 *
 * @property int $id
 * @property int|null $parent_page_id
 * @property int|null $page_component_id
 * @property int|null $galleriable_id
 * @property string|null $galleriable_type
 * @property string|null $link
 * @property int $order
 * @property string $type
 * @property int $active
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\PageComponent|null $component
 * @property-read Model|\Eloquent $galleriable
 * @property-read \App\Models\Page $parent
 * @property-read \Modules\Gallery\Entities\GalleryTranslation|null $translation
 * @property-read \Illuminate\Database\Eloquent\Collection|\Modules\Gallery\Entities\GalleryTranslation[] $translations
 * @property-read int|null $translations_count
 * @method static \Illuminate\Database\Eloquent\Builder|Gallery active($active = true)
 * @method static \Illuminate\Database\Eloquent\Builder|Gallery actual()
 * @method static \Illuminate\Database\Eloquent\Builder|Gallery first()
 * @method static \Illuminate\Database\Eloquent\Builder|Gallery listsTranslations(string $translationField)
 * @method static \Illuminate\Database\Eloquent\Builder|Gallery newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Gallery newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Gallery notTranslatedIn(?string $locale = null)
 * @method static \Illuminate\Database\Query\Builder|Gallery onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Gallery orWhereTranslation(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Gallery orWhereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Gallery orderByTranslation(string $translationField, string $sortMethod = 'asc')
 * @method static \Illuminate\Database\Eloquent\Builder|Gallery published($lang = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Gallery query()
 * @method static \Illuminate\Database\Eloquent\Builder|Gallery translated()
 * @method static \Illuminate\Database\Eloquent\Builder|Gallery translatedIn(?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Gallery whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Gallery whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Gallery whereGalleriableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Gallery whereGalleriableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Gallery whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Gallery whereLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Gallery whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Gallery wherePageComponentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Gallery whereParentPageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Gallery whereTranslation(string $translationField, $value, ?string $locale = null, string $method = 'whereHas', string $operator = '=')
 * @method static \Illuminate\Database\Eloquent\Builder|Gallery whereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Gallery whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Gallery withAndWhereHas($relation, $constraint)
 * @method static \Illuminate\Database\Eloquent\Builder|Gallery withPageComponent($alias)
 * @method static \Illuminate\Database\Eloquent\Builder|Gallery withTranslation()
 * @method static \Illuminate\Database\Query\Builder|Gallery withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Gallery withoutTrashed()
 * @mixin \Eloquent
 */
class Gallery extends Model implements TranslatableContract
{
    // Трейт для "мягкого удаления"
    use SoftDeletes;

    // Трейт для автоматического перевода
    use Translatable;

    // Трейт для сортировки
    use Sortable;

    // Трейт для автоматическое кеширование
    // use Cachable;

    // Трейт для виджета
    use WidgetTrait;

    // Трейт для миникартинок
    use ThumbsTrait;

    //
    use QueryTrait;

    const TYPE_VIDEO = 'video';
    const TYPE_PHOTO = 'photo';

    public $translatedAttributes = [
        'image',
        'name',
        'alt',
        'publish'
    ];

    public $timestamps = false;

    protected $dates = ['deleted_at'];

    protected $fillable = ['parent_page_id', 'page_component_id', 'galleriable_id', 'galleriable_type', 'link', 'type', 'order', 'active'];


    public function getTranslationModelName(): string
    {
        return GalleryTranslation::class;
    }
    /***
     * Возвращает связанную полиморфной связью запись
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function galleriable()
    {
        return $this->morphTo();
    }


    public function scopeFirst($query)
    {
        return $query->actual->limit(1);
    }


    public function scopeActual($query)
    {
        return $query
            ->active()
            ->published()
            ->whereTranslation('locale', app()->getLocale());
    }


//    protected static function boot()
//    {
//        parent::boot();
//
//        self::creating(function ($model) {
//            $model->order = self::max('order') + 1;
//        });
//    }


    protected static function booted()
    {
        static::addGlobalScope(new OrderScope());
    }


    public function setYoutubePreview($link, $type="hqdefault")
    {
        $path = "http://i3.ytimg.com/vi/";

        $resolution = array (
            'maxresdefault',
            'sddefault',
            'mqdefault',
            'hqdefault',
            'default'
        );
        $url = parse_url($link);

        //Expect the URL to be http://youtu.be/abcd, where abcd is the video ID
        if($url['host'] == 'youtu.be') :
            $imgPath = ltrim($url['path'],'/');

        //Expect the URL to be http://www.youtube.com/embed/abcd
        elseif (strpos($url['path'],'embed') == 1) :
            $arr = explode('/',$url['path']);
            $imgPath = end($arr);

        //Expect the URL to be abcd only
        elseif (strpos($link,'/') === false):
            $imgPath = $link;

        //Expect the URL to be http://www.youtube.com/watch?v=abcd
        else :
             parse_str($url['query'], $output);
            $imgPath = $output['v'];
        endif;

        return $path.$imgPath.'/'.$type.'.jpg';
    }

}
