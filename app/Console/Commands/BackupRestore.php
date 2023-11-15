<?php

namespace App\Console\Commands;

use ZipArchive;
use App\Services\BackupService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Console\Output\ConsoleOutput;

class BackupRestore extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'backup:restore';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make restore backup database';

    private $disk;

    private $storagePath;
    private $backupPath;

    private $backup_from;
    private $backup_to;


    const DIR_FROM_ZIP = 'db-dumps';
    const SQL_FILE_NAME = 'mysql-otdushki.sql';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();



        $this->disk = Storage::disk(config('backup.backup.destination.disks')[0]);
        // dd($this->disk);
        // return;
        $this->storagePath = $this->disk->getAdapter()->getPathPrefix();
        $this->backupPath = $this->storagePath . config('backup.backup.name');

        $this->backup_from = self::DIR_FROM_ZIP . DIRECTORY_SEPARATOR . self::SQL_FILE_NAME;
        $this->backup_to = config('backup.backup.temporary_directory') . DIRECTORY_SEPARATOR . self::SQL_FILE_NAME;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // получаем все бекапы
        $backups = $this->getBackupNames();
        $cnt = is_array($backups) ? count($backups) : 0;

        if ($cnt > 0) {

            $items = [];
            foreach ($backups as $key => $backup) {
                $items[$key] = 'Backup: ' . $backup['file_name'] . ' size: ' . $backup['file_size'];
            }


            $title = 'Which database restoration file should be used?';
            // вызываем диалоговое окно
            $selected = $this->showDialog($title, $items);


            if ($selected !== null) {


                try {

                    // получаем название выбранного архива
                    $backupZip = $this->backupPath . DIRECTORY_SEPARATOR . $backups[$selected]['file_name'] . '.zip';

                    // удаляем таблицы из базы данных
                    $this->dropDatabaseTables();

                    // делаем копию sql-файла из архива во временную директорию
                    $this->unzipFile($backupZip);

                    //восстанавливаем базу
                    $this->info('Start restore from ' . $backups[$selected]['file_name']);

                    if (app(BackupService::class)->restore($this->backup_to)) {

                        $this->info('Backup from ' . $backups[$selected]['file_name'] . ' restore success');
                        // удаляем временный файл
                        $this->deleteTempFile();
                    }
                } catch (\Exception $e) {
                    dump($e->getMessage());
                }
            }
        } else {

            $this->info('Backups from path "' . $this->backupPath . '" not found.');
        }

        return 0;
    }



    private function unzipFile($filename)
    {
        $zip = new ZipArchive();
        if ($zip->open($filename) === TRUE) {
            File::put($this->backup_to, $zip->getFromName($this->backup_from));
        }
        $zip->close();
    }


    private function deleteTempFile()
    {
        File::delete($this->backup_to);
    }




    private function dropDatabaseTables()
    {
        $this->info('Drop exist tables');
        $tables = DB::connection()->getDoctrineSchemaManager()->listTableNames();
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        foreach ($tables as $table) {
            Schema::drop($table);
        }
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        $this->info('Drop exist tables success');
    }



    private function showDialog($title, $items)
    {

        if (Command::hasMacro('menu')) {

            try {

                return $this->menu($title, $items)->open();
            } catch (\Exception $e) {

                $choice = $this->choice($title, $items);
                return array_search($choice, $items);
            }
        } else {
            $choice = $this->choice($title, $items);
            return array_search($choice, $items);
        }
    }




    protected function getBackupNames()
    {
        $files = $this->disk->files('/' . config('backup.backup.name') . '/');
        $backups = [];
        foreach ($files as $k => $f) {
            if (substr($f, -4) == '.zip' && $this->disk->exists($f)) {
                $backups[] = [
                    'file_path' => $f,
                    'file_name' => $this->humanFileName($f),
                    'file_size' => $this->humanFileSize($this->disk->size($f)),
                    'last_modified' => $this->disk->lastModified($f),
                ];
            }
        }
        return array_reverse($backups);
    }


    private function humanFileName($file)
    {
        $file_name = str_replace(config('laravel-backup.backup.name') . config('backup.backup.name') . '/', '', $file);
        return str_replace('.zip', '', $file_name);
    }


    private function humanFileSize($size, $unit = "")
    {
        if ((!$unit && $size >= 1 << 30) || $unit == "GB")
            return number_format($size / (1 << 30), 2) . "GB";
        if ((!$unit && $size >= 1 << 20) || $unit == "MB")
            return number_format($size / (1 << 20), 2) . "MB";
        if ((!$unit && $size >= 1 << 10) || $unit == "KB")
            return number_format($size / (1 << 10), 2) . "KB";
        return number_format($size) . " bytes";
    }
}
