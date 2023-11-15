<?php

namespace App\Console\Commands;

use Barryvdh\TranslationManager\Models\Translation;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;

class GenerateTranslationJson extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'trans:json';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generates messages.js file from static translations in resources/js/lang directory for use in js';

    /**
     * @var string
     */
    private $template;
    /**
     * @var string
     */
    private $path;
    /**
     * @var string
     */
    private $file;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->template = "module.exports = '{ messages }'";
        $this->path = resource_path().'/js/lang/';
        $this->file = 'messages.js';
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $usedGroups = config('localization-js.messages');
        $translations = [];

        if($usedGroups){
            Translation::whereIn('group', $usedGroups)

                ->orderBy('id', 'desc')
                ->orderBy('key', 'asc')
                ->orderBy('locale','desc')
                ->get()
                ->each(function ($rec) use (&$translations) {
                    $flattened = $rec->locale.'.'.$rec->group;
                    $translations[$flattened][] = [ $rec->key => $rec->value];
                });

            $this->template = str_replace('\'{ messages }\'', json_encode($translations),  $this->template);
            $this->template = str_replace('[','', $this->template);
            $this->template = str_replace(']','', $this->template);
            $this->template = str_replace('},{',',', $this->template);

            \File::put($this->path.$this->file,$this->template);
        }



        return 0;
    }


    protected function array_undot($dottedArray) {
        $array = array();
        foreach ($dottedArray as $key => $value) {
            array_set($array, $key, $value);
        }
        return $array;
    }
}
