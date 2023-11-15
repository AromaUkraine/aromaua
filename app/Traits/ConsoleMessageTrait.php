<?php


namespace App\Traits;


trait ConsoleMessageTrait
{
    protected $green = "\e[32m";
    protected $white = "\e[37m";

    /**
     * Show process data
     * @param $message
     * @param int $total
     * @param int $current
     */
    public function process($message, $total = 0, $current = 0)
    {
        echo "\033[61D";      // Move 5 characters backward
        $input = $message . $this->green . $total . "/" . $current;
        $length = strlen($input);
        echo str_pad($input, $length, ' ', STR_PAD_LEFT);
    }


    public function message($message="", $php_eol = false)
    {
        if($php_eol)
            echo PHP_EOL;

        echo $this->green.$message.$this->white.PHP_EOL;
    }
}
