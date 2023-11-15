<?php


namespace Modules\Catalog\Providers;


use Illuminate\Support\ServiceProvider;
use Modules\Catalog\Console\AlphabetBrandOrder;
use Symfony\Component\Finder\Finder;

class CommandServiceProvider extends ServiceProvider
{
    public function boot()
    {


    }

    public function register()
    {
        $this->commands([
            AlphabetBrandOrder::class
        ]);
        // $this->registerCommands(module_path('Catalog', 'Console'));
        // $this->registerCommands('Modules\Catalog\Console');
    }

    protected function registerCommands($namespace = '')
    {
        $finder = new Finder(); // from Symfony\Component\Finder;
        $finder->files()->name('*Command.php')->in($namespace);

        dump($finder);

        $classes = [];
        foreach ($finder as $file) {
            $class = $namespace.'\\'.$file->getBasename('.php');
//            dump( $namespace.'\\'.$file->getBasename('.php'));
            array_push($classes, $class);
        }
//        dd($classes);

        $this->commands($classes);
    }
}
