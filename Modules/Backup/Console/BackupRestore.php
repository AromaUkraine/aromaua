<?php

namespace Modules\Backup\Console;

use Artisan;
use ZipArchive;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Modules\Backup\Services\BackupService;
use Modules\Backup\Services\ArchiveService;
use Modules\Backup\Services\DatabaseService;
use Symfony\Component\Console\Input\InputOption;
use Modules\Backup\Services\DialogConsoleService;
use Symfony\Component\Console\Input\InputArgument;
use Spatie\Backup\BackupDestination\BackupDestination;

class BackupRestore extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'backup:restore';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make restore backup database.';

    /**
     * Storage object
     *
     * @var object
     */
    protected $disk;

    /**
     * Путь к основной директории в которой храниться резервные копии
     *
     * @var string
     */
    protected $storage_path;

    /**
     * Путь к папке в которой храниться резервные копии
     *
     * @var string
     */
    protected $backup_path;


    protected $dir_name;

    /**
     * Название файла дампа базы данных
     *
     * @var string
     */
    protected $sql_file_name;

    /**
     * Путь к файлу внутри zip-архива
     *
     * @var string
     */
    protected $backup_in_archive_destination;

    /**
     * Путь к временному файлу из которого будет производится восстановление базы данных
     *
     * @var string
     */
    protected $backup_temporary_destination;


    public $backups;

    /**
     * Название директории в которой хранится дамп базы данных в zip-архиве
     */
    const DIR_FROM_ZIP = 'db-dumps';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $engine = config('database.default');
        $db_name = config('database.connections.'.$engine.'.database');

        $this->disk = Storage::disk(config('backup.backup.destination.disks')[0]);

        $this->storage_path = $this->disk->getAdapter()->getPathPrefix();

       

        $this->dir_name = Str::kebab(config('backup.backup.name'));

        
        $this->backup_path = $this->storage_path . $this->dir_name;
        
        $this->sql_file_name = $engine.'-'.$db_name.'.sql';

        $this->backup_in_archive_destination = self::DIR_FROM_ZIP . DIRECTORY_SEPARATOR . $this->sql_file_name;

        $this->backup_temporary_destination = config('backup.backup.temporary_directory') . DIRECTORY_SEPARATOR . $this->sql_file_name;

        // получаем все бекапы
        $this->backups = app(BackupService::class)->getBackups($this->disk, $this->dir_name);
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $items = $this->makeItems();

        $cnt = is_array($items) ? count($items) : 0;

        if(!$cnt){
            $this->info('No backup found');
            return;
        }

        
        if (Arr::accessible($this->backups)) {

            Artisan::call('down');

            $number_selected = $this->getSelected($items, 'Which database restoration file should be used?');
           
            if ($number_selected !== null) {
                $this->backupAction($number_selected);
            }

            Artisan::call('up');

        }
    }



    /**
     * Создаем отображение бекапов для диалогового окна
     *
     * @param array $backups
     * @return array
     */
    protected function makeItems()
    {
        $items = [];
        foreach ($this->backups as $key => $backup) {
            $items[$key] = 'Backup: ' . $backup['file_name'] . ' size: ' . $backup['human_file_size'];
        }
        return $items;
    }


    /**
     * Вызываем диалоговое окно
     *
     * @param array $items
     * @param string $title
     * @return null|int
     */
    protected function getSelected($items, $title = '')
    {
        return app(DialogConsoleService::class)->show($this, $items, $title);
    }


    protected function backupAction($number_selected)
    {
        $file_name = $this->backups[$number_selected]['file_name'];

       
        $this->info('Start restore from ' . $file_name);

        // получаем название выбранного архива
        $backupZip = $this->backup_path . DIRECTORY_SEPARATOR . $file_name . '.zip';

        
        if(app(ArchiveService::class)
            ->moveCopyZipFile($backupZip, $this->backup_temporary_destination, $this->backup_in_archive_destination)){
            
            $this->info('Copy database from archive created success.');

            $this->info('Begining drop database tables');   

            if(app(DatabaseService::class)->dropAll()){

                $this->info('Drop database tables success');

                //восстанавливаем базу
                $this->info('Start restore from ' . $file_name.'. Database recovery may take some time.');

                if (app(BackupService::class)->restore($this->backup_temporary_destination)) {

                    // удаляем временный файл
                    app(ArchiveService::class)->deleteFile($this->backup_temporary_destination);

                    $this->info('Backup from ' . $file_name . ' restore success');
                }

            }else{

                $this->info('Database tables not droped.');
            }

        }else{

            $this->info('Copy database not created.');
        }
    }

}
