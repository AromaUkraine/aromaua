<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEntityComponentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entity_components', function (Blueprint $table) {
            $table->id();
            $table->string('table')->comment('имя таблицы в базе данных к записи которой будет добавляться дополнительный компонент');
            $table->string('model')->comment('полный путь к модели записи');
            $table->string('name')->default('cms.gallery')->comment('перевод в под меню записи');
            $table->string('icon')->nullable()->comment('иконка в под меню');
            $table->string('slug')->comment('
                базовый роут привязанного компонента записи. Например для статей привязываем галлерею module.entity_gallery.index
                если эта запись привязана к какой-то странице. Или module.gallery.index если запись к странице не привязана как например товары, категории товаров');
            $table->string('route_key')->comment('имя роута без action для возвращения назад из привязанного к записи компонента в саму запись.
            Например для статьи - module.article');
            $table->string('relation')->comment('связь с моделью компонента - для удаления');
//            $table->string('relation_with_category')->comment('имя поля которое сязывает запись с категорией (если такая связь вообще есть).
//            Нужно например для товара, чтобы получить прикрепленные к категории характеристики и список значений каждой из характеристики.')->nullable();
            $table->integer('order')->default(0)->comment('сортировка');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('entity_components');
    }
}
