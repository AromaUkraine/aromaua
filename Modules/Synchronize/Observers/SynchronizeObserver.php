<?php

namespace Modules\Synchronize\Observers;

use Modules\Synchronize\Entities\Synchronize;

class SynchronizeObserver
{


    public function saved(Synchronize $sync)
    {
        $sync->translations->each(function ($t) {
            $t->update(['metaphone_key' => $this->makeMetaphone($t->name)]);
        });
    }


    private function makeMetaphone($name)
    {
        if (strlen($name)) {
            $name = \Transliterate::make($name);
            return metaphone($name);
        }

        return null;
    }
}
