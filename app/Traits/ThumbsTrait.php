<?php


namespace App\Traits;


trait ThumbsTrait
{

    public function thumbs($dir = '', $field = 'image')
    {
        if (config('app.filemanager') === 'rfm') {
            $base_thumbs_path = DIRECTORY_SEPARATOR . config('rfm.thumbs_base_path');

            if ($dir) :
                if (\File::isDirectory(public_path($base_thumbs_path . $dir)))
                    $base_thumbs_path .= $dir . DIRECTORY_SEPARATOR;
            endif;

            return str_replace(config('rfm.upload_dir'), $base_thumbs_path, $this->$field);
        }

        if (config('app.filemanager') === 'lfm') {
            return $this->$field;
        }
    }
}