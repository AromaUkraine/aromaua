<?php

namespace Modules\Backup\Console;

use Exception;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Modules\Backup\Services\ArchiveService;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class BackupDb extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'backup:db';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make backup mysql dump database.';


    protected $disk;

    protected $databaseName;

    protected $dir_name;

    protected $storage_path;

    protected $backup_path;

    protected $sql_file_name;

    protected $backup_in_archive_destination;

    protected $backup_temporary_destination;

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
        $this->databaseName = config('database.connections.'.$engine.'.database');
        $this->userName = config('database.connections.'.$engine.'.username');
        $this->password = config('database.connections.'.$engine.'.password');


        $this->disk = Storage::disk(config('backup.backup.destination.disks')[0]);
        $this->dir_name = Str::kebab(config('backup.backup.name'));
        $this->storage_path = Storage::disk('local')->url('app') . DIRECTORY_SEPARATOR . $this->dir_name;
        $this->storage_path = ltrim($this->storage_path,'/');


        $this->backup_path = $this->storage_path . $this->dir_name;
        $this->sql_file_name = $engine.'-'.$this->databaseName.'.sql';
        $this->backup_in_archive_destination = self::DIR_FROM_ZIP . DIRECTORY_SEPARATOR . $this->sql_file_name;
        $this->backup_temporary_destination = config('backup.backup.temporary_directory');
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        if($this->make()){
            app(ArchiveService::class)->zip(
                $this->getArchiveName(),
                $this->backup_temporary_destination,
                self::DIR_FROM_ZIP,
                $this->backup_path
            );
        }

        $this->info('Begining dump database complete.');

        app(ArchiveService::class)->deleteFile($this->backup_temporary_destination . DIRECTORY_SEPARATOR . $this->sql_file_name);
    }

    protected function make()
    {
        try{

            $this->info('Begining dump database tables');

            if(!File::isDirectory($this->backup_temporary_destination)){
                File::makeDirectory($this->backup_temporary_destination, 0777, true, true);
            }

            \Spatie\DbDumper\Databases\MySql::create()
                ->setDbName($this->databaseName)
                ->setUserName($this->userName)
                ->setPassword($this->password)
                ->dumpToFile($this->backup_temporary_destination . DIRECTORY_SEPARATOR . $this->sql_file_name);

            return true;
        }catch(Exception $e) {
            dd($e->getMessage());
        }
    }



    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            // ['example', InputArgument::REQUIRED, 'An example argument.'],
        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            // ['example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null],
        ];
    }


    protected function getArchiveName()
    {

        return $this->storage_path . DIRECTORY_SEPARATOR . Carbon::now()->format('Y-m-d-H-m-s').'.zip';
    }
}
