<?php

namespace Modules\Backup\Services;

use Exception;
use ZipArchive;
use Illuminate\Support\Facades\File;

class ArchiveService
{
    /**
     * Вынимает файл из zip-архива и ложит его копию в указанную директорию
     *
     * @param string $zip - полный путь к zip-архиву
     * @param string $to
     * @param string $from
     * @return void
     */
    public function moveCopyZipFile($zipFile, $to, $from)
    {
       
        try{

            $zip = new ZipArchive();
            if ($zip->open($zipFile) === TRUE) {
                File::put($to, $zip->getFromName($from));
            }
            $zip->close();

            return true;

        }catch(Exception $e){
            dump($e->getMessage());
        }

        return false;
    }


    /**
     * Undocumented function
     *
     * @param string $archiveName - путь к будушему zip-архиву внутри приложения 
     * @param string $structure - путь к файлу внутри zip-архива
     * @param string $from - путь к файлу во временной директории
     * @return bool
     */
    public function zip($archive, $file,  $dir,  $to)
    {
        try{

            $zip = new ZipArchive();
            if ($zip->open($archive, ZipArchive::CREATE) === TRUE){

                $files = File::files($file);
                foreach ($files as $key => $value) {
                    $relativeNameInZipFile = $dir . DIRECTORY_SEPARATOR . basename($value);
                    $zip->addFile($value, $relativeNameInZipFile);
                }
                
                $zip->close();
            }

            return true;
        }catch(Exception $e){
            dump($e->getMessage());
        }

        return false;
        
    }

    public function deleteFile($file)
    {
        File::delete($file);
    }

    public function getDirName()
    {
       return str_replace(' ','-', config('backup.backup.name'));
    }
}
