<?php


namespace App\Services;


use Illuminate\Support\Str;
use Buglinjo\LaravelWebp\Webp;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;

class WebpService
{

    public function create($file, string $path, string $filename, $quality = null)
    {
        try {

            $full_filename = $filename . '.' . config('laravel-webp.file_extension', 'webp');

            // если файл не был создан
            if (!File::exists($path . $full_filename)) {

               $webp =  Webp::make($file)->save($path . $full_filename, $quality);

            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }
    }

    /**
     * Создает ссылки для webp
     *
     * @param string $image_path
     * @return string
     */
    public function make($image_path = null)
    {

        if(!$image_path)
            return '';

        $srcset = '';
        $full_path = public_path($image_path);



        if (File::exists($full_path)) {

            $image = response()->file($full_path)->getFile();
            $filename = File::name($full_path);
            $path = str_replace(public_path(), '', $image->getPath());
            $relative_path = str_replace(config('rfm.upload_dir'), config('laravel-webp.file_path'), $image_path);
            $relative_path = Str::beforeLast($relative_path, $filename);

            if (File::exists(public_path($relative_path . $filename . '.' . config('laravel-webp.file_extension'))))
                $srcset .= $relative_path . $filename . '.webp 1x';

            if (File::exists(public_path($relative_path . $filename . '-2x.' . config('laravel-webp.file_extension'))))
                $srcset .= ', ' . $relative_path . $filename . '-2x.webp 2x';
        }

        return $srcset;
    }


    /**
     * Созает относительный путь к файлу webp относительно директории uploads сохраняя вложенность
     * @param string $image_path
     * @param string $filename
     * @return string - full path to webp file
     */
    public function makePath($image_path, $filename)
    {
        $path = str_replace(config('rfm.upload_dir'), '', $image_path);

        $path = Str::beforeLast($path, $filename);

        $path = public_path(config('laravel-webp.file_path') . $path);

        if (!File::isDirectory($path)) {
            File::makeDirectory($path, 0777, true, true);
        }

        return $path;
    }
}