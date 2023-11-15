<?php


namespace App\Services;

use App\Models\Language;

class   Languages
{
    private $query;

    /***
     *  Return collection
     * @return mixed
     */
    public function get(){

        return $this->query->get();
    }


    /***
     *  Return array slugs
     * @return array
     */
    public function slug()
    {
        $languages = $this->query->get();
        if($languages->count()) {
            return $languages->pluck('short_code')->all();
        }

        return array_wrap(config('app.locale'));
    }


    /**
     *  Активные языки
     * @param $segment
     * @return mixed
     */
    public function active($segment = null)
    {
        try{
            if($segment){
                $this->query = Language::whereIn('short_code',[$segment, config('app.locale')])->whereActive(true)->newQuery();
            }else{
                $this->query = Language::whereActive(true)->newQuery();
            }
            return $this;
        }catch(\Exception $e) {

        }
    }

    /**
     * Все языки
     *
     * @return $this
     */
    public function all(){
        try{
            $this->query = (new Language())->newQuery();
            return $this;
        }catch (\Exception $e){

        }
    }

    /***
     * @return array
     */
    public function trashed(){

        $this->query = (new Language())->withTrashed()->get();

        return $this->slug();
    }
}
