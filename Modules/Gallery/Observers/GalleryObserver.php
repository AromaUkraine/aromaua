<?php


namespace Modules\Gallery\Observers;

use App\Services\ImageService;
use App\Services\WebpService;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Modules\Gallery\Entities\Gallery;

class GalleryObserver
{


    public function __construct()
    {
        $this->locales = app()->languages->all()->slug();
    }

    /**
     * Handle the Gallery "created" event.
     *
     * @param Gallery $gallery
     * @return void
     */
    public function creating(Gallery $gallery)
    {
        // увеличиваем порядковый номер сортировки
        $gallery->order = Gallery::max('order') + 1;


        if (request()->has('image')) {
            // получаем коллекцию путей к изображениям
            $image_paths = app(ImageService::class)->getImagesCollectionOnJsonData(request()->image);

            if ($image_paths->count()) {

                $image_paths->each(function ($image_path) {


                    // полный путь к изображению
                    $full_path = public_path() . $image_path;

                    // если файл существует
                    if (File::exists($full_path)) {

                        try {

                            // получам файл из полного пути к файлу
                            $file = app(ImageService::class)->getUploadedFileFromPath($full_path);

                            // имя файла без расширения файла - по этому имени будем сохранять сгенерированные файлы
                            $filename = File::name($full_path);

                            // создание пути к директории webp сохраняя структуру директории из uploads директории
                            $webp_path = app(WebpService::class)->makePath($image_path, $filename);

                            // тут можно сделать уменьшенные копии изображений, увеличенные копии, watermarks

                            // Создание изображения в формате webp
                            app(WebpService::class)->create($file, $webp_path, $filename);
                        } catch (\Exception $e) {
                            Log::error($e->getMessage());
                        }
                    } else {
                        Log::warning('file with path ' . $full_path . ' not found.');
                    }
                });
            }
        }
    }

    /**
     * Handle the User "updated" event.
     *
     * @param Gallery $gallery
     * @return void
     */
    public function updating(Gallery $gallery)
    {


        foreach ($this->locales as $locale) {

            if ($gallery->translate($locale) && $gallery->translate($locale)->image) {

                $image_path = $gallery->translate($locale)->image;

                // полный путь к изображению
                $full_path = public_path($image_path);

                // если файл существует
                if (File::exists($full_path)) {

                    try {
                        // получам файл из полного пути к файлу
                        $file = app(ImageService::class)->getUploadedFileFromPath($full_path);

                        //  имя файла без расширения файла - по этому имени будем сохранять сгенерированные файлы
                        $filename = File::name($full_path);

                        // создание пути к директории webp сохраняя структуру директории из uploads директории
                        $webp_path = app(WebpService::class)->makePath($image_path, $filename);

                        // тут можно сделать уменьшенные копии изображений, увеличенные копии, watermarks

                        // // Создание изображения в формате webp
                        app(WebpService::class)->create($file, $webp_path, $filename);
                    } catch (\Exception $e) {
                        Log::error($e->getMessage());
                    }
                } else {
                    Log::warning('file with path ' . $full_path . ' not found.');
                }

            }
        }
    }
}