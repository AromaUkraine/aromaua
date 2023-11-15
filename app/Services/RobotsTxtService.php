<?php


namespace App\Services;


class RobotsTxtService
{
    protected $file = 'robots.txt';

    protected $path;

    protected $lines = [
        'User-agent: *',
        'Disallow: /cms'
    ];


    public function __construct(){

        $this->path = public_path($this->file);

        return $this;
    }


    public function exist()
    {
        return \File::exists($this->path);
    }


    public function get()
    {
        return \File::get($this->path);
    }


    public function make()
    {
        $content = implode(PHP_EOL, $this->lines);

        $this->put($content);
    }


    public function put($content)
    {
        \File::put($this->path, $content);
    }


}
