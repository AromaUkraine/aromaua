<?php

namespace Modules\Backup\Services;

use Illuminate\Console\Command;

class DialogConsoleService
{
    /**
     * Show dialog console window
     *
     * @param array $items
     * @param string|null $title
     * @return void
     */
    public function show(Command $command, array $items, ?string $title = '')
    {
        if (Command::hasMacro('menu')) {

            try {

                return $command->menu($title, $items)->open();

            } catch (\Exception $e) {

                $choice = $command->choice($title, $items);
                return array_search($choice, $items);
            }

        } else {
            $choice = $command->choice($title, $items);
            return array_search($choice, $items);
        }
    }
}
