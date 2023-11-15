<?php

namespace App\Console\Commands;


use App\Helpers\ArrayHelper;
use App\Models\Menu;
use App\Models\Permission;
use App\Traits\ConsoleMessageTrait;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class MenuRefreshCommand extends Command
{
    use ConsoleMessageTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'menu:refresh';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add new, remove if not exist menu items';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        if (Schema::hasTable('menus')) {
            $this->refresh();
        }

        $this->message('Refresh menu completed successfully.');
    }

    /***
     *  Обновление пунктов меню
     */
    private function refresh()
    {

        $menu = Menu::backend()->get();
        $locales = app()->languages->all()->slug();
        $keys = (new Permission())->keys;
        $permissions = Permission::where('action', 'index')->whereIn('type', $keys)->get();

        // удаляем пункты меню которые уже не существуют
        $this->removedNotExist($menu, $permissions);
        // создаем новые пункты меню
        $this->createdNew($menu, $permissions, $locales);
    }


    private function removedNotExist($menu, $permissions)
    {
        $menu->each(function ($item) use ($permissions) {

            if ($item->permission_id) {
                if (!$permissions->contains('id', $item->permission_id)) {
                    $item->delete();
                }
            }
        });
    }

    public function createdNew($menu, $permissions, $locales)
    {
        $permissions->each(function ($item) use ($menu, $locales) {

            // не создаем главную страницу
            if(\Str::contains($item->slug, 'home')){
                return;
            }


            if (!$menu->contains('permission_id', $item->id)) {

                if (Str::contains($item->type, 'root')) {

                    // create menu item
                    $this->createMenu($item, $locales);
                } else {
                    $root = $menu->where('type', $item->type)->first();

                    if ($root) {

                        // create menu item
                        $node = $this->createMenu($item, $locales);
                        // attach item to root
                        $root->appendNode($node);
                    }
                }
            }
        });
    }

    private function createMenu($permission, $locales)
    {
        $data = [
            'icon' => 'far fa-file',
            'permission_id' => $permission->id,
        ];

        foreach ($locales as $locale) {
            $data[$locale] = [
                'name' => $permission->slug,
            ];
        }

        return Menu::create($data);
    }
}
