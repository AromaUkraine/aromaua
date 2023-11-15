<?php


namespace Modules\Map\View\Google;


use Illuminate\View\Component;
use phpDocumentor\Reflection\Types\Boolean;

class Map extends Component
{

    /**
     * @var string
     */
    private $path = 'https://maps.googleapis.com/maps/api/js';

    /**
     * @var string
     */
    private $map_type = 'libraries=places';

    /**
     * @var object|null
     */
    public $model;

    /**
     * @var string
     */
    public $lat;

    /**
     * @var string
     */
    public $lng;

    /**
     * @var string
     */
    public $src;
    /**
     * @var string
     */
    public $watch;

    /**
     * @var string
     */
    public $address;
    /**
     * @var string
     */
    public $height;
    /**
     * @var bool
     */
    public $info = null;

    public $setMarker = null;

    public function __construct( $height = '300', $address = null, $lat=null, $lng=null)
    {
        $this->lat = $lat;
        $this->lng = $lng;
        $this->address = $address;
        $this->height = $height;
        $this->src = $this->getSrc();

        $this->setMarker = !request()->has('delete');
    }

    /**
     * @return \Closure|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|string
     */
    public function render()
    {
        return view('map::components.google.map');
    }

    public function setValue($field)
    {
        if(isset($this->model->$field)) :
            return $this->model->$field;
        endif;

        return null;
    }

    /**
     * @return mixed
     */
    private function getGoogleApiKey()
    {
        return app()->settings->key('google-map-api-key')->value;
    }

    /**
     * @return string
     */
    private function getSrc()
    {
        return $this->path."?key={$this->getGoogleApiKey()}&{$this->map_type}";
    }

    /**
     * @param $watch
     */
    private function setAddress($watch)
    {
        if(isset($this->model->$watch)) :
            $this->value =$this->model->$watch;
        else:
            $this->value = '';
        endif;
    }

    private function setInfoContent(bool $info)
    {
        if($info && $this->model) :
            $this->info = view('components.cms.google.info')
                ->with(['model'=>$this->model])
                ->render();
        endif;
    }
}
