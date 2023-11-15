<?php

namespace App\View\Components\Cms\FileManager;


use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\View\Component;

class FileManagerConstruct extends Component
{


    /**
     * @var string
     */
    public $name;


    /**
     * @var string|null
     */
    public $options;

    /**
     * @var string|null
     */
    public $params;

    /**
     * @var array|string
     */
    public $src = null;

    /**
     * @var bool
     */
    public $issetImages = true;


    /**
     * @var int
     * множественный выбор
     * 1 - включен
     * 0 - выключен
     */
    public $multiple = 0;

    /**
     * @var int
     * 0 - all files
     * 1 - image
     * 2 - files
     * 3 - video
     */
    private $type = 1;


    /**
     * @var string
     * Подпака внутри uploads/files ак папка по умолчанию
     */
    private $fldr = "";


    /**
     * @var string
     * элемент для сортировки (значения: имя, размер, расширение, дата) default = ""
     */
    private $sort_by = "";

    /**
     * @var int
     * по убыванию 1,  по возрастанию 0
     */
    private $descending = 0;


    /**
     * @var int
     * следует добавить в запрос значение "1" при открытии RFM. В противном случае возвращенные URL-адреса будут абсолютными
     */
    private $relative_url = 1;

    /**
     * @var string
     * массив доступных расширений файлов в кодировке json
     */
    private $extension = '';

    /**
     * @var string
     * имя callback метода
     */
    private $external = null;


    private $notFoundImage = "images/not_found.png";


    /**
     * Undocumented variable
     *
     * @var null|string
     */
    protected $filemanager = null;

    /**
     * Create a new component instance.
     *
     * @param string $name
     * @param string|null $options - parameters for parent element
     * @param string|null $params - parameters for url filemanager
     * @param array $src - path to image in to app directory
     */
    public function __construct(?string $name = null, ?string $options = null, ?string $params = null,  $src = null)
    {
        $this->name = $name;

        $this->setOptions($options);
        $this->setParams($params);
        $this->makeImages($src);

        $this->filemanager = config('app.filemanager','rfm');
    }


    /**
     * @param $src
     *  Check isset image
     */
    protected function makeImages($src)
    {

        if($src) {

            $src = json_decode($src, true);

            if ( is_array($src) ) {

                foreach ($src as $item) {
                    $this->src[] = $this->setImagePath($item);
                }

            } else {

                $this->src[0] = $this->setImagePath($src);
            }
        }

    }

    /**
     * @param $src
     * @return array
     * Set image path
     */
    protected function setImagePath($src)
    {

        if($src) {

            $data['image'] = asset($this->notFoundImage);
            $data['thumbs'] = asset($this->notFoundImage);

            $image = preg_replace("/(?<!=)\"(?!>)/", '', $src);
            $thumbs = '/'.str_replace(config('rfm.upload_dir'), config('rfm.thumbs_base_path'), $image);

            if ( \File::exists( public_path($image) ) ) {

                $data['image'] = $image;

                if ( \File::exists( public_path($thumbs) ) ) {
                    $data['thumbs'] = $thumbs;
                }
            }

            return $data;
        }

        return [];
    }


    /**
     * @param $params
     * Set params in to url filemanager
     * Пока не нашел приминения :)
    */
    protected function setParams($params)
    {
        $params = json_decode($params, true);

        if(isset($params['multiple']))
            $this->multiple = 1;

        $this->params = '';
        $this->params .= (isset($params['type'])) ? "type={$params['type']}" : "type={$this->type}";
        $this->params .= (isset($params['fldr'])) ? "&fldr={$params['fldr']}" : "";
        $this->params .= (isset($params['sort_by'])) ? "&sort_by={$params['sort_by']}" : "";
        $this->params .= (isset($params['descending'])) ? "&descending={$params['descending']}" : "";
        $this->params .= (isset($params['relative_url'])) ? "&relative_url={$params['relative_url']}" : "&relative_url={$this->relative_url}";
        $this->params .= (isset($params['extension'])) ? "&extension={$params['extension']}" : "";
        $this->params .= (isset($params['external'])) ? "&external={$params['external']}" : "";
        $this->params .= (isset($params['lang'])) ? "&lang={$params['lang']}" : "&lang=" . app()->getLocale();
    }


    /**
     * @param $options
     * Set html options in to parent element
     */
    protected function setOptions($options)
    {
        if ($options) {

            $options = json_decode($options, true);
        }

        if (is_array($options) && count($options)) {

            foreach ($options as $key => $value) {
                $this->options .= "$key={$value} ";
            }
        }
    }

    /**
     * @return \Illuminate\View\View|string|void
     * @throws \Exception
     */
    public function render()
    {
        throw new \Exception('This is just a class constructor');
    }
}
