
## LARAVEL CMS


## Установка
1. Скопировать .env.example и настроить окружение
```
cp .env.example .env
```
Настроить окружение

2. Запустить composer и установить все зависимости
```
composer install
```

3. Установить зависимости для npm
```
npm install
```

4. Сгенерировать application encryption key
```
php artisan key:generate
```

5. Сгенерировать ключ для файлового менеджера
```
php artisan rfm:generate
```

6. Запустить миграции и заполнить базу демо-данными
```
php artisan migrate --seed
```



### Вход в админ-зону

**Email:** admin@admin.com  
**Login:** admin  
**Password:** secret


Обновление в базе всех доступов, после добавления или удаления routes (cms)

```
php artisan permissions:refresh  
```

Обновление menu в кабинете, после добавления или удаления routes (cms)

```
php artisan menu:refresh  
```


### Сторонние библиотеки

1. Datatable - https://github.com/yajra/laravel-datatables
2. Кеширование моделей - https://github.com/GeneaLabs/laravel-model-caching (С пакетом много сложностей, возможно нужно просто удалить)
3. Мультиязычность моделей - https://github.com/Astrotomic/laravel-translatable
```php способ использовать переводы в модулях (проверить)
 public function getTranslationModelName(): string 
 { 
     return $this->translationModel ?: $this->getTranslationModelNameDefault(); 
 } 
 ```
4. Логирование моделей - https://github.com/VentureCraft/revisionable
5. Всплывающие сообщения - https://github.com/tjgazel/laravel-toastr
6. Переводы статического текста - https://github.com/barryvdh/laravel-translation-manager
7. Файл менеджер - https://github.com/Kwaadpepper/laravel-responsivefilemanager
````markdown
    "kwaadpepper/laravel-responsivefilemanager": "^0.0.10"
    устанавливать эту версию - разработчик все время меняет код, не факт что
    новая версия будет адекватна.
    Если картинка не грузится. Такое случается когда картинка берется из сторонних ресурсов
    в файле dialog.php этой библиотеки
    найти //blueimp.github.io/JavaScript-Load-Image/js/load-image.all.min.js и 
    заменить на //cdnjs.cloudflare.com/ajax/libs/blueimp-load-image/2.18.0/load-image.all.min.js
````   

8. Транслитерация - https://github.com/ElForastero/Transliterate ( необходимо установить расширение php_intl.dl
 использую персональный доступ по имени synchronize_api
```
12. Генерация webp формата изображений  - https://github.com/buglinjo/laravel-webp
````markdown
 После переноса на другой сервер - обязательно изменить абсолютный путь 
    к бинарнику cwebp в библиотеке libwebp в конфигурационном файле laravel-webp 
    и сбросить кеш конфигурации
````

13. Альтернативный файловый менеджер - https://github.com/UniSharp/laravel-filemanager
```
В файле config/app.php параметр filemanager
lfm - включает laravel filemanager
rfm - включает responsive filemanager (из пакета kwaadpepper)
```

14. Логирование в базе данных - https://freesoft.dev/program/145064955

15. Backup базы данных - https://spatie.be/docs/laravel-backup/v7/installation-and-setup

``` ошибка при установке
Если во время установки вознакает ошибка:
Target [Spatie\Backup\Tasks\Cleanup\CleanupStrategy] is not instantiable while building [Spatie\Backup\Commands\CleanupCommand].
Нужно удалить файл /boostrap/cache/config.php
```




16. Интерактивное меню в консоли - https://github.com/nunomaduro/laravel-console-menu



### Настройки локального сервера
- Apache_2.4-PHP_7.2-7.3-x64
- PHP_7.3-x64
- MariaDB-10.3-x64

### server


Данные для доступа к серверу:
https://srv193250.xyzservers.net:8083
    username: admin
    password: 8iXiDL6mT428ThlC

ssh: 91.219.28.57
root
8iXiDL6mT428ThlC

доступ по ssh
ssh root@91.219.28.57
pass 8iXiDL6mT428ThlC

mysql
database : admin_otdushki
username : admin_otdushki
password : D0gU1N4fLs

Address site
http://srv193250.xyzservers.net

Путь к директории сайта
/home/admin/web/srv193250.xyzservers.net/public_html

path to repo folder
/var/repo/otdushki.git


Папка для тестирования файлов синхронизации (в нее помещать все json-файлы)
public/synchronize/demo

***Консольные комманды***

``` backup базы данных
php artisan backup:run --only-db
```


```восстановление базы данных из backup 
php artisan backup:restore
```


- Сбросить (удалить) синхронизированные данные
```
php artisan remote-data:reset
```
- Запустить синхронизацию
```
php artisan api-data:import
```

!!! Во время синхронизации сайт будет не доступен.
