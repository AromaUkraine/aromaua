<x-card>

    <div class="accordion" id="accordionWrapa1" data-toggle-hover="true">
        <div class="card collapse-header ">
            <div id="heading1" class="card-header" role="tablist" data-toggle="collapse" data-target="#accordion1" aria-expanded="true" aria-controls="accordion1">
                <span class="collapse-title">Галлерея</span>
            </div>
            <div id="accordion1" role="tabpanel" data-parent="#accordionWrapa1" aria-labelledby="heading1" class="collapse " style="">
                <div class="card-body pb-0">
                    <div class="list-group mt-1">
                        <a href="#article"
                           data-action="#entity_component"
                           class="list-group-item list-group-item-action setFormData">новости</a>
                        <ul id="article" class="hidden">
                            <li data-name="table">articles</li>
                            <li data-name="model">Modules\Article\Entities\Article</li>
                            <li data-name="slug">module.entity_gallery.index</li>
                            <li data-name="route_key">module.article</li>
                            <li data-name="relation">gallery</li>
                            <li data-name="name">cms.gallery</li>
                        </ul>
                        <a href="#product"
                           data-action="#entity_component"
                           class="list-group-item list-group-item-action setFormData">товара</a>
                        <ul id="product" class="hidden">
                            <li data-name="table">products</li>
                            <li data-name="model">Modules\Catalog\Entities\Product</li>
                            <li data-name="slug">module.gallery.index</li>
                            <li data-name="route_key">catalog.product</li>
                            <li data-name="relation">gallery</li>
                            <li data-name="name">cms.gallery</li>
                        </ul>
                        <a href="#product_category"
                           data-action="#entity_component"
                           class="list-group-item list-group-item-action setFormData">категории товара</a>
                        <ul id="product_category" class="hidden">
                            <li data-name="table">product_categories</li>
                            <li data-name="model">Modules\Catalog\Entities\ProductCategory</li>
                            <li data-name="slug">module.gallery.index</li>
                            <li data-name="route_key">catalog.product_category</li>
                            <li data-name="relation">gallery</li>
                            <li data-name="name">cms.gallery</li>
                        </ul>
                        <a href="#seo_page"
                           data-action="#entity_component"
                           class="list-group-item list-group-item-action setFormData">сео-страницы</a>
                        <ul id="seo_page" class="hidden">
                            <li data-name="table">seo_catalogs</li>
                            <li data-name="model">Modules\Catalog\Entities\SeoCatalog</li>
                            <li data-name="slug">module.gallery.index</li>
                            <li data-name="route_key">catalog.seo_catalog</li>
                            <li data-name="relation">gallery</li>
                            <li data-name="name">cms.gallery</li>
                        </ul>
                        <a href="#brand_on_page"
                           data-action="#entity_component"
                           class="list-group-item list-group-item-action setFormData">бренд на отдельной странице брендов</a>
                        <ul id="brand_on_page" class="hidden">
                            <li data-name="table">seo_catalogs</li>
                            <li data-name="model">Modules\Catalog\Entities\SeoCatalog</li>
                            <li data-name="slug">module.entity_gallery.index</li>
                            <li data-name="route_key">module.brand_list</li>
                            <li data-name="relation">gallery</li>
                            <li data-name="name">cms.gallery</li>
                        </ul>
                    </div>
                </div>
                <div class="card-footer" style="font-size: small;">
                    <div class="alert alert-secondary" role="alert">
                        <p> В галлереи создано 2 контроллера для привязки ее к записи внутри страницы.</p>
                        <p>
                            Например на странице новостей к самой новости прикреплена галлерея - нужно
                            использовать роут к компоненту <br><b>module.entity_gallery.index</b>
                        </p>
                        <p>
                            Для привязки галлереи к записи вне страницы, например каталог товаров - товар - галлерея
                            <br><b>module.gallery.index</b>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="card collapse-header">
            <div id="heading2" class="card-header" data-toggle="collapse" role="button" data-target="#accordion2" aria-expanded="false" aria-controls="accordion2">
                <span class="collapse-title">Баннеры</span>
            </div>
            <div id="accordion2" role="tabpanel" data-parent="#accordionWrapa1" aria-labelledby="heading2" class="collapse" aria-expanded="false">
                <div class="card-body pb-0">
                    <div class="list-group mt-1">
                        <a href="#banner_article"
                           data-action="#entity_component"
                           class="list-group-item list-group-item-action setFormData">новости</a>
                        <ul id="banner_article" class="hidden">
                            <li data-name="table">articles</li>
                            <li data-name="model">Modules\Article\Entities\Article</li>
                            <li data-name="slug">module.page_entity_banner.index</li>
                            <li data-name="route_key">module.article</li>
                            <li data-name="relation">entity_banner</li>
                            <li data-name="name">cms.banner</li>
                        </ul>
                    </div>
                </div>
                <div class="card-footer" style="font-size: small;">
                    <div class="alert alert-secondary" role="alert">
                        <p> В модуле banner создано 2 контроллера для привязки баннера к странице и привязке баннера непосредственно к записи.</p>
                        <p>
                            Например к странице главная, новости, каталог, блог, контакты и т.д. - используется виджет.
                        </p>
                        <p>
                            Для привязки баннера к записи без родительской страницы, например категории товаров, товару и т.д. указываем имя роута к компоненту
                            <br><b>module.entity_banner.index</b>
                        </p>
                        <p>
                            Для привязки баннера к записи с родительской страницей, например новости на странице новостей и т.д. указываем имя роута к компоненту
                            <br><b>module.page_entity_banner.index</b>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="card collapse-header">
            <div id="heading3" class="card-header" data-toggle="collapse" role="button" data-target="#accordion3" aria-expanded="false" aria-controls="accordion3">
                <span class="collapse-title">Характеристики</span>
            </div>
            <div id="accordion3" role="tabpanel" data-parent="#accordionWrapa1" aria-labelledby="heading3" class="collapse" aria-expanded="false">
                <div class="card-body pb-0">
                    <div class="list-group mt-1">
                        <a href="#feature_product_category"
                           data-action="#entity_component"
                           class="list-group-item list-group-item-action setFormData">категории товаров</a>
                        <ul id="feature_product_category" class="hidden">
                            <li data-name="table">product_categories</li>
                            <li data-name="model">Modules\Catalog\Entities\ProductCategory</li>
                            <li data-name="slug">module.category_feature.index</li>
                            <li data-name="route_key">catalog.product_category</li>
                            <li data-name="relation">entity_features</li>
                            <li data-name="name">cms.feature</li>
                        </ul>
                        <a href="#feature_product"
                           data-action="#entity_component"
                           class="list-group-item list-group-item-action setFormData">товара</a>
                        <ul id="feature_product" class="hidden">
                            <li data-name="table">products</li>
                            <li data-name="model">Modules\Catalog\Entities\Product</li>
                            <li data-name="slug">module.product_feature.index</li>
                            <li data-name="route_key">catalog.product</li>
                            <li data-name="relation">entity_features</li>
                            <li data-name="name">cms.feature</li>
                        </ul>
                        <a href="#feature_seo_page"
                           data-action="#entity_component"
                           class="list-group-item list-group-item-action setFormData">сео-страницы</a>
                        <ul id="feature_seo_page" class="hidden">
                            <li data-name="table">seo_catalogs</li>
                            <li data-name="model">Modules\Catalog\Entities\SeoCatalog</li>
                            <li data-name="slug">module.seo_catalog_feature.index</li>
                            <li data-name="route_key">catalog.seo_catalog</li>
                            <li data-name="relation">entity_features</li>
                            <li data-name="name">cms.feature</li>
                        </ul>
                    </div>
                    <div class="card-footer" style="font-size: small;">

                    </div>
                </div>
            </div>
        </div>















        <div class="card collapse-header">
            <div id="heading4" class="card-header" data-toggle="collapse" role="button" data-target="#accordion4" aria-expanded="false" aria-controls="accordion4">
                <span class="collapse-title">Разное</span>
            </div>
            <div id="accordion4" role="tabpanel" data-parent="#accordionWrapa1" aria-labelledby="heading4" class="collapse" aria-expanded="false">
                <div class="card-body pb-0">
                    <div class="list-group mt-1">
                        <a href="#product_list_on_seo_page"
                           data-action="#entity_component"
                           class="list-group-item list-group-item-action setFormData">Список товаров на сео-странице</a>
                        <ul id="product_list_on_seo_page" class="hidden">
                            <li data-name="table">seo_catalogs</li>
                            <li data-name="model">Modules\Catalog\Entities\SeoCatalog</li>
                            <li data-name="slug">module.seo_catalog_product.index</li>
                            <li data-name="route_key">catalog.seo_catalog</li>
                            <li data-name="relation">entity_features</li>
                            <li data-name="name">cms.product_list</li>
                        </ul>
                        <a href="#product_discount"
                           data-action="#entity_component"
                           class="list-group-item list-group-item-action setFormData">Скидки товаров</a>
                        <ul id="product_discount" class="hidden">
                            <li data-name="table">products</li>
                            <li data-name="model">Modules\Catalog\Entities\Product</li>
                            <li data-name="slug">module.entity_discount.index</li>
                            <li data-name="route_key">catalog.product</li>
                            <li data-name="relation">discounts</li>
                            <li data-name="name">cms.discount</li>
                        </ul>

                        <a href="#contact_map"
                           data-action="#entity_component"
                           class="list-group-item list-group-item-action setFormData">Google map для магазина</a>
                        <ul id="contact_map" class="hidden">
                            <li data-name="table">shops</li>
                            <li data-name="model">Modules\Shop\Entities\Shop</li>
                            <li data-name="slug">module.entity_map.index</li>
                            <li data-name="route_key">root.shop</li>
                            <li data-name="relation">map</li>
                            <li data-name="name">cms.google_map</li>
                        </ul>

                    </div>
                </div>
                <div class="card-footer" style="font-size: small;">

                </div>
            </div>
        </div>

        <div class="card collapse-header">
            <div id="heading3" class="card-header" data-toggle="collapse" role="button" data-target="#accordion5" aria-expanded="false" aria-controls="accordion3">
                <span class="collapse-title">Контактная информация</span>
            </div>
            <div id="accordion5" role="tabpanel" data-parent="#accordionWrapa1" aria-labelledby="heading3" class="collapse" aria-expanded="false">
                <div class="card-body pb-0">
                    <div class="list-group mt-1">
                        <a href="#entity_contacts"
                           data-action="#entity_component"
                           class="list-group-item list-group-item-action setFormData">Магазин</a>
                        <ul id="entity_contacts" class="hidden">
                            <li data-name="table">shops</li>
                            <li data-name="model">Modules\Shop\Entities\Shop</li>
                            <li data-name="slug">module.entity_contact.index</li>
                            <li data-name="route_key">root.shop</li>
                            <li data-name="relation">contacts</li>
                            <li data-name="name">cms.entity_contact</li>
                        </ul>
                    </div>
                    <div class="card-footer" style="font-size: small;">

                    </div>
                </div>
            </div>
        </div>

    </div>

</x-card>

@push('scripts')
    <script>
        $('a.setFormData').click(function(){
            let formId = $(this).data('action');
            let ulId = $(this).attr('href');
            let form = $(formId);
            let ul = $(ulId);
            let data = getListData(ul);
            // console.log('formId', formId)
            // console.log('ulId', ulId)
            // console.log('form', form)
            // console.log('ul', ul)
            // console.table('data', data)
            if(data.length) {
                fillForm(form, data);
            }
        });

        const fillForm = function (form, data){
            clearForm(form);
            if(typeof form !== typeof undefined){
                $.each(data, function (idx, item){
                    let input =form.find(`input[name='${item.name}']`)[0];
                    if(typeof input !== typeof undefined) {
                        $(input).val(item.value);
                    }
                })
            }
        }

        const getListData = function (ul){
            let data = [];

            if(typeof ul !== typeof undefined && ul.length) {
                $('li', ul).map( (index, item) => {
                    data.push({
                        name:$(item).data('name'),
                        value:$(item).html(),
                    })
                })
            }
           return data;
        }

        const clearForm = function(form) {
            if(typeof form !== typeof undefined){
                $(':input',form).not(':button, :submit, :reset, :hidden').val('');
            }
        }
    </script>
@endpush
