### Модуль Backup
Для работы модуля необходимо чтобы был установлен пакет реализующий основной функционал
https://spatie.be/docs/laravel-backup/v7/installation-and-setup

``` ошибка при установке
Если во время установки вознакает ошибка:
Target [Spatie\Backup\Tasks\Cleanup\CleanupStrategy] is not instantiable while building [Spatie\Backup\Commands\CleanupCommand].
Нужно удалить файл /boostrap/cache/config.php
```

``` backup только базы данных
php artisan backup:run --only-db
```

```backup всего
php artisan backup:run
```

### Интерактивное меню в консоли

    https://github.com/nunomaduro/laravel-console-menu

## Восстановление базы данных
```
php artisan backup:restore
```
Комманда выводит список доступных резервных копий баз данных. При выборе копии - сносит текущую базу данных и восстанавливает базу из копии