## Seo-catalog

### Добавление middleware

1. Добавить в \App\Http\Kernel в
раздел $routeMiddleware 
   
```
'seo_catalog' => \Modules\Catalog\Http\Middleware\SeoCatalogMiddleware::class
```

2. Добавить в роутинг middleware

```
Route::group([ 'middleware'=>['seo_catalog'] ], function() {
            ....
        })
```
