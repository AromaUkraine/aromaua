<?php


namespace App\Services;

use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;

class ImageService
{

    const SINGLE = 'single';
    const MULTIPLE = 'multiple';
    /**
     * @var \Symfony\Component\HttpFoundation\File\File
     */
    protected $image;

    /**
     * Содержание поля name приходит в формате json как массив содержащий n-ое кол-во елементов.
     * Метод возвращает результат преобразования значения поля $name в строку - путь к картинке или массив картинок
     * @param $name
     * @param $data
     * @param string $type
     * @return mixed
     */
    public function make($name, $data, $type = self::SINGLE)
    {
        $locales = app()->languages->all()->slug();

        if (isset($data[$name])) {
            $data[$name] = $this->makeResult($data[$name], $type);
        }

        foreach ($locales as $locale) {

            if (isset($data[$locale][$name])) {

                $data[$locale][$name] = $this->makeResult($data[$locale][$name], $type);
            }
        }

        return $data;
    }


    /**
     * @param $data
     * @param $type
     * @return mixed
     */
    private function makeResult($data, $type)
    {
        $res = json_decode($data, true);
        // возвращает первый элемент как строку
        if ($type && $type == self::SINGLE) {

            return $res[0];
        }

        return $res;
    }


    public function makeBigImage(string $image_path)
    {
        $srcset = '';
        $public_path = public_path($image_path);

        if (File::exists($public_path)) {
            // относительный путь /uploads/...
            $relative_path = \Str::beforeLast($image_path, '/') . '/';
            // object image
            $image = response()->file($public_path)->getFile();
            $ext = $image->getExtension();

            // without type
            $name = $this->getFileName($image);

            if (File::exists($image->getPath() . '/' . $name . '-3x.' . $ext)) {
                $srcset .= $relative_path . $name . '-3x.' . $ext;
            }
        }

        return $srcset;
    }

    protected function getFileName($image)
    {
        return  str_replace('.' . $image->getExtension(), '', $image->getFilename());
    }


    /**
     * Create an UploadedFile object from absolute path
     *
     * @static
     * @param string $path
     * @return    object(Symfony\Component\HttpFoundation\File\UploadedFile)
     */
    public function getUploadedFileFromPath(string $path)
    {
        $name = File::name($path);

        $extension = File::extension($path);

        $originalName = $name . '.' . $extension;

        $mimeType = File::mimeType($path);

        $size = File::size($path);

        $error = false;

        return new UploadedFile($path, $originalName, $mimeType, $size, $error);
    }

    /**
     * Преобразует json data картинок в коллекцию
     * @param $images_json_data
     * @return \Illuminate\Support\Collection
     */
    public function getImagesCollectionOnJsonData($images_json_data): \Illuminate\Support\Collection
    {

        $data = json_decode($images_json_data, true);

        $images = collect();
        foreach ($data as $image_group) {
            if (is_array($image_group)) {
                foreach ($image_group as $image) {
                    $images->push($image);
                }
            } else {
                $images->push($image_group);
            }
        }
        return $images;
    }
}