<?php


namespace App\Helpers;


use App\Models\Permission;
use App\Models\Role;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

class PermissionHelper
{
    // префикс для защищенных разрешений
    const CMS = 'cms';

    // действие в контроллере по умолчанию (если не указано в списке разрешений, например cms.home )
    const DEFAULT_ACTION = 'index';

    const ACTION_KEY = 'slug';

    const DEFAULT_CONTROLLER = 'home';

    /**
     * Возвращает массив защищенных slugs
     *
     * @param array $slugs
     * @return array
     */
    public static function getProtectedUrlSlugs( $slugs=[] )
    {

        $data = [];
        $result = [];

        if(count($slugs)) {

            foreach ($slugs as $key=>$val) {
                $data[$val] = self::comparePermissions($val);
            }
        }else{
            $data[self::CMS] = self::comparePermissions(self::CMS);
        }

        array_walk_recursive($data, function ($item, $key) use (&$result) {
            $result[] = $item;
        });

        return $result;
    }

    protected static function comparePermissions($key)
    {

        $result = [];

        $routeCollection = Route::getRoutes()->get();
        foreach ($routeCollection as $route) {

            $action = $route->getAction();
            if (array_key_exists('as', $action)) {
                if(str_is($key.'.*', $action['as'])){
                    $result[] = $action['as'];
                }
            }
        }

        return $result;
    }

    /**
     * Преобразовывает массив защищенных доступов
     * @param mixed ...$slugs
     * @return array
     */
    public static function getPermissionsSlugName($slugs = [])
    {

        $data = [];
        $protectedUrls = [];

        if(!$slugs){
            $protectedUrls = self::getProtectedUrlSlugs();
        }else{
            $protectedUrls = array_merge($protectedUrls, self::getProtectedUrlSlugs($slugs));
        }

        foreach ($protectedUrls as $key=>$value) {

            $name = self::removePrefix($value);
            $name = Str::ucfirst(str_replace('.'," ", $name));

            $data[] = [
                'name'=>$name,
                self::ACTION_KEY=>$value
            ];
        }

        return $data;
    }

    /**
     * Возвращает все Permission
     *
     * @param null $column
     * @param null $value
     * @param string $operator
     * @return array
     */
    public static function getAllPermissions($column = null, $value=null, $operator="=")  {

        $query = (new Permission())->newQuery();
        if($column && $value){
            $query->where($column,$operator,$value);
        }

        // разработчику доступен полный список доступов, остальным же все исключая доступы разработчика
        if(\Auth::user()->role->slug == Role::DEVELOPER_ROLE){
            $permissions = $query->get()->toArray();
        }else{
            $permissions = $query->whereNotIn('type',[Role::DEVELOPER_ROLE])->get()->toArray();
        }

        if( !ArrayHelper::cnt($permissions,0) ) {

            foreach ($permissions as $key=>$value) {
                $items = explode('.', $value[self::ACTION_KEY]);
                $items[2] = (!isset($items[2])) ? self::DEFAULT_ACTION : $items[2];
                $permissions[$key]['module'] = $items[0];
                $permissions[$key]['controller'] = $items[1];
                $permissions[$key]['action'] = $items[2];
            }
        }
        return $permissions;
    }


    protected static function removePrefix($str)
    {
        return str_replace(self::CMS.'.','', $str);
    }
}
