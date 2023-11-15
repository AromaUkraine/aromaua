<?php

namespace Modules\Synchronize\Console;

use Illuminate\Console\Command;
use App\Traits\ConsoleMessageTrait;
use Modules\Synchronize\Events\ApiSynchronizeEvent;


class ApiSynchronizeImport extends Command
{
    use ConsoleMessageTrait;
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'api-data:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Загрузка данных по api.';

    private $shutdownSite;

    private $upload_folder;
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->shutdownSite = app()->settings->val('shutdown-site') ?? false;

        $folder = app()->settings->val('synchronize-folder') ?? '';
        $folder = rtrim($folder,'/');
        $folder = ltrim($folder,'/');
        $this->upload_folder = $folder;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->message('Synchronization with the api started', true);

        if($this->shutdownSite)
            \Artisan::call('down');

        event(new ApiSynchronizeEvent($this->upload_folder));

        if($this->shutdownSite)
           \Artisan::call('up');

        $this->message('Synchronization with the api completed', true);

        return null;
    }
}
