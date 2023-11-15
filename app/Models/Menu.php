<?php

namespace App\Models;


use App\Traits\ExtendedNodeTrait;
use App\Traits\PageTrait;
use App\Traits\QueryTrait;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Modules\AdditionalPage\Traits\AdditionalEntitiesOnMenuTrait;

/**
 * App\Models\Menu
 *
 * @property int $id
 * @property int|null $permission_id
 * @property int|null $page_id
 * @property string|null $icon
 * @property int $active
 * @property int $_lft
 * @property int $_rgt
 * @property int|null $parent_id
 * @property string|null $type
 * @property string $data
 * @property string $from
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Kalnoy\Nestedset\Collection|Menu[] $children
 * @property-read int|null $children_count
 * @property-read \App\Models\Page|null $page
 * @property-read Menu|null $parent
 * @property-read \App\Models\Permission|null $permission
 * @property-read \App\Models\Page $rootPage
 * @property-read \App\Models\Translations\MenuTranslation|null $translation
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Translations\MenuTranslation[] $translations
 * @property-read int|null $translations_count
 * @method static \Kalnoy\Nestedset\QueryBuilder|Menu active($active = true)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Menu actual(?string $locale = null)
 * @method static \Kalnoy\Nestedset\Collection|static[] all($columns = ['*'])
 * @method static \Kalnoy\Nestedset\QueryBuilder|Menu ancestorsAndSelf($id, array $columns = [])
 * @method static \Kalnoy\Nestedset\QueryBuilder|Menu ancestorsOf($id, array $columns = [])
 * @method static \Kalnoy\Nestedset\QueryBuilder|Menu applyNestedSetScope(?string $table = null)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Menu backend()
 * @method static \Kalnoy\Nestedset\QueryBuilder|Menu belongsPage($belongs_id, $active = true, $publish = true, $class = null, $locale = null)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Menu countErrors()
 * @method static \Kalnoy\Nestedset\QueryBuilder|Menu d()
 * @method static \Kalnoy\Nestedset\QueryBuilder|Menu defaultOrder(string $dir = 'asc')
 * @method static \Kalnoy\Nestedset\QueryBuilder|Menu descendantsAndSelf($id, array $columns = [])
 * @method static \Kalnoy\Nestedset\QueryBuilder|Menu descendantsOf($id, array $columns = [], $andSelf = false)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Menu fixSubtree($root)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Menu fixTree($root = null)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Menu frontend()
 * @method static \Kalnoy\Nestedset\Collection|static[] get($columns = ['*'])
 * @method static \Kalnoy\Nestedset\QueryBuilder|Menu getNodeData($id, $required = false)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Menu getPlainNodeData($id, $required = false)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Menu getTotalErrors()
 * @method static \Kalnoy\Nestedset\QueryBuilder|Menu hasChildren()
 * @method static \Kalnoy\Nestedset\QueryBuilder|Menu hasParent()
 * @method static \Kalnoy\Nestedset\QueryBuilder|Menu isBroken()
 * @method static \Kalnoy\Nestedset\QueryBuilder|Menu joinPage($active = null, $publish = null, $class = null, $locale = null)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Menu joinPageAll($active = true, $publish = true, $class = null)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Menu joinTranslation($publish = null, ?string $slug = null, ?string $locale = null)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Menu latestPage($field = null)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Menu leaves(array $columns = [])
 * @method static \Kalnoy\Nestedset\QueryBuilder|Menu listsTranslations(string $translationField)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Menu makeGap(int $cut, int $height)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Menu moveNode($key, $position)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Menu newModelQuery()
 * @method static \Kalnoy\Nestedset\QueryBuilder|Menu newQuery()
 * @method static \Kalnoy\Nestedset\QueryBuilder|Menu notTranslatedIn(?string $locale = null)
 * @method static \Illuminate\Database\Query\Builder|Menu onlyTrashed()
 * @method static \Kalnoy\Nestedset\QueryBuilder|Menu orWhereAncestorOf(bool $id, bool $andSelf = false)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Menu orWhereDescendantOf($id)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Menu orWhereNodeBetween($values)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Menu orWhereNotDescendantOf($id)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Menu orWhereTranslation(string $translationField, $value, ?string $locale = null)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Menu orWhereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Menu orderByTranslation(string $translationField, string $sortMethod = 'asc')
 * @method static \Kalnoy\Nestedset\QueryBuilder|Menu published($lang = null)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Menu query()
 * @method static \Kalnoy\Nestedset\QueryBuilder|Menu rebuildSubtree($root, array $data, $delete = false)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Menu rebuildTree(array $data, $delete = false, $root = null)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Menu reversed()
 * @method static \Kalnoy\Nestedset\QueryBuilder|Menu root(array $columns = [])
 * @method static \Kalnoy\Nestedset\QueryBuilder|Menu translated()
 * @method static \Kalnoy\Nestedset\QueryBuilder|Menu translatedIn(?string $locale = null)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Menu whereActive($value)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Menu whereAncestorOf($id, $andSelf = false, $boolean = 'and')
 * @method static \Kalnoy\Nestedset\QueryBuilder|Menu whereAncestorOrSelf($id)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Menu whereData($value)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Menu whereDeletedAt($value)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Menu whereDescendantOf($id, $boolean = 'and', $not = false, $andSelf = false)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Menu whereDescendantOrSelf(string $id, string $boolean = 'and', string $not = false)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Menu whereFrom($value)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Menu whereIcon($value)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Menu whereId($value)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Menu whereIsAfter($id, $boolean = 'and')
 * @method static \Kalnoy\Nestedset\QueryBuilder|Menu whereIsBefore($id, $boolean = 'and')
 * @method static \Kalnoy\Nestedset\QueryBuilder|Menu whereIsLeaf()
 * @method static \Kalnoy\Nestedset\QueryBuilder|Menu whereIsRoot()
 * @method static \Kalnoy\Nestedset\QueryBuilder|Menu whereLft($value)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Menu whereNodeBetween($values, $boolean = 'and', $not = false)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Menu whereNotDescendantOf($id)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Menu wherePageId($value)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Menu whereParentId($value)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Menu wherePermissionId($value)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Menu whereRgt($value)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Menu whereTranslation(string $translationField, $value, ?string $locale = null, string $method = 'whereHas', string $operator = '=')
 * @method static \Kalnoy\Nestedset\QueryBuilder|Menu whereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Menu whereType($value)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Menu withAndWhereHas($relation, $constraint)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Menu withDepth(string $as = 'depth')
 * @method static \Kalnoy\Nestedset\QueryBuilder|Menu withPage(bool $active = true, bool $publish = true, bool $class = null)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Menu withTranslation()
 * @method static \Illuminate\Database\Query\Builder|Menu withTrashed()
 * @method static \Kalnoy\Nestedset\QueryBuilder|Menu withTypes(?array $types = null)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Menu withoutRoot()
 * @method static \Illuminate\Database\Query\Builder|Menu withoutTrashed()
 * @mixin \Eloquent
 */
class Menu extends Model implements TranslatableContract
{
    // Трейт автоматического перевода
    use Translatable;

    // Трейт "мягкого удаления"
    use SoftDeletes;

    // Расширенный трейт NodeTrait
    use ExtendedNodeTrait;

    // Трейт связи со страницей
    use PageTrait;

    use QueryTrait;

    const ACTIVE = 1;

    const NOT_ACTIVE = 0;

    const BACKEND = 'backend';

    const FRONTEND = 'frontend';

    // поля которые имеют перевод
    public $translatedAttributes = ['name', 'publish'];

    protected $fillable = [
        'permission_id',
        'page_id',
        'icon',
        'active',
        'parent_id',
        'type',
        'data',
        'from',
    ];

    public $timestamps = false;

    protected $dates = ['deleted_at'];

    protected $guarded = [];

    /**
     * Связь с доступами
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function permission()
    {
        return $this->belongsTo(Permission::class);
    }

    public function page()
    {
        return $this->belongsTo(Page::class);
    }



    /**
     * Условие для получения только backend пунктов меню
     * @param $query
     * @return mixed
     */
    public function scopeBackend($query)
    {
        return $query->where('from', self::BACKEND);
    }

    /**
     * Условие для получения только frontend пунктов меню
     * @param $query
     * @return mixed
     */
    public function scopeFrontend($query)
    {
        return $query->where('from', self::FRONTEND);
    }


    public function childrenRecursive()
    {
        return $this->children()->with('childrenRecursive');
    }

    public static function countChildPages($menu)
    {
        $menu->pagesCount = 0;
        $menu->pagesCount += $menu->childrenRecursive->count();
        foreach ($menu->childrenRecursive as $child) {
            $menu->pagesCount += self::countChildPages($child);
        }
        return $menu->pagesCount;
    }

}
