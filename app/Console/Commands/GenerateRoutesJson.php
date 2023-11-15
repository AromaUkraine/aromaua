<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Routing\Router;

class GenerateRoutesJson extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'route:json';

    protected $router;

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make json api routes';

    /**
     * Create a new command instance.
     *
     * @param Router $router
     */
    public function __construct(Router $router)
    {
        parent::__construct();

        $this->router = $router;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $routes = [];

        foreach ($this->router->getRoutes() as $route) {
            if(isset($route->action['prefix']) && $route->action['prefix'] === 'api' ) {

                if($name = $route->getName()){
                    $routes[$route->getName()] = $route->uri();
                }

            }
        }

        \File::put('resources/js/routes/api.json', json_encode($routes, JSON_PRETTY_PRINT));

        return 0;
    }
}
