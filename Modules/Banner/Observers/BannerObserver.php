<?php

namespace Modules\Banner\Observers;

use App\Services\WebpService;
use App\Services\ImageService;
use Illuminate\Support\Facades\Log;
use Modules\Banner\Entities\Banner;
use Illuminate\Support\Facades\File;


class BannerObserver
{

    public function __construct()
    {

        $this->locales = app()->languages->all()->slug();
    }

    /**
     * Handle the Banner "creating" event.
     *
     * @param Banner $banner

     * @return void
     */
    public function creating(Banner $banner)
    {
        // увеличиваем порядковый номер сортировки
        $banner->order = Banner::max('order') + 1;

        foreach ($this->locales as $locale) {

            if (request()->has($locale) && isset(request()->$locale['image'])) {

                // получаем коллекцию путей к изображениям
                $image_paths = app(ImageService::class)->getImagesCollectionOnJsonData(request()->$locale['image']);

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
    }

    /**
     * Handle the Banner "updating" event.
     *
     * @param Banner $banner
     * @return void
     */
    public function updating(Banner $banner)
    {

        foreach ($this->locales as $locale) {

            if ($banner->translate($locale) && $banner->translate($locale)->image) {

                $image_path = $banner->translate($locale)->image;
                
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