<div class="seo_catalog_features" >
    <div class="row">
        <div class="col-md-5 col-12 mb-50">
            <label class="text-nowrap label  @if(!$entity_features->count()) hidden @endif">{{__('cms.select_feature_from_list')}}</label>
        </div>
        <div class="col-md-5 col-12 mb-50">
            <label class="text-nowrap label  @if(!$entity_features->count()) hidden @endif">{{__('cms.select_feature_value')}}</label>
        </div>
    </div>
    @if($entity_features)
        @foreach($entity_features as $feature)
            <div class="repeater-list" data-repeater-list>
                <div class="row justify-content-between" >
                    <div class="col-md-5 col-12 form-group d-flex align-items-center">
                        <select  class="select2 form-control feature">
                            @foreach($all_features as $all)
                                <option value="{{ $all->id }}" {{ $setFeatureSelected($feature, $all->id) }}>{{$all->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-5 col-12 form-group">
                        <select name="feature[]" multiple class="select2 form-control" {{ $setOptions($feature) }}  >
                            @foreach($getOptions as $option)
                                <option value="{{$option['value']}}" {{ $setFeatureValueSelected($feature, $option) }}>{{$option['name']}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2 col-12 form-group">
                        <button
                            class="btn btn-icon btn-danger rounded-circle data-repeater-delete"
                            type="button" >
                            <i class="bx bx-x"></i>
                        </button>
                    </div>
                </div>
            </div>
        @endforeach
    @endif

    <div class="repeater-list cloned" data-repeater-list>

        <div class="row justify-content-between" >
            <div class="col-md-5 col-12 form-group d-flex align-items-center">
                <div class="preview preview__feature">
                    <input type="text" class="form-control" disabled >
                </div>
            </div>
            <div class="col-md-5 col-12 form-group">
                <div class="preview preview__feature-value">
                    <input type="text" class="form-control" disabled >
                </div>
            </div>
            <div class="col-md-2 col-12 form-group">
                <button
                    class="btn btn-icon btn-danger rounded-circle data-repeater-delete"
                    type="button" >
                    <i class="bx bx-x"></i>
                </button>
            </div>
        </div>
    </div>
</div>

<x-button
    class="success my-2 mr-1 float-right data-repeater-create"
    type="button"
    title="{{__('cms.buttons.add')}}"
    icon="bx bx-plus"
>
</x-button>

<div id="show"></div>

@push('scripts')

    <script>
        $(function(){
            // основной контейнер
            let container = $('.seo_catalog_features');
            // повторяющийся блок
            let repeater = $(".cloned");
            let body = $('body');
            let addButton = $('.data-repeater-create');
            let selectCategory = $('#product_category_id');
            let product_category_id = null;
            let confirmChangeCategory = false;
            repeater.remove();

            // смена категории
            selectCategory.on('change', function (){

                // если была выбрана категория или добавлена хотя бы одна характеристика
                if(product_category_id || container.find('.repeater-list').length) {
                    let data = {
                        'title': "{{__('datatable.delete.title')}}",
                        'message':'Смена категории товара, удалит все выбранные характеристики',
                        'confirmButtonText' : "{{__('datatable.delete.confirmButtonText')}}",
                        'cancelButtonText' : "{{__('datatable.delete.cancelButtonText')}}",
                    };
                    $.confirm(data, function (res) {
                        confirmChangeCategory = (res && typeof res !== undefined) ?? false;
                        // удаляет все выбранные ранее хар-ки при смене категории и прячет заголовки
                        if(confirmChangeCategory) {
                            container.find('.repeater-list').remove();
                            toggleLabel('hide');
                        }
                    });
                }

                product_category_id = $(this).val();
            });

            // добавление повторяющегося ряда
            addButton.on('click', function (){

                getFeature(function (data){

                    // создает копию повторяющегося элемента, находит по классу место куда будет помещен елемент data
                    // очищает и помещает data на место, копию помещает в конец контейнера
                    let clone = repeater.clone();
                    let feature = clone.find('.preview__feature');
                    feature.empty().append(data);
                    clone.appendTo(container);

                    reinitSelect();
                    toggleLabel('show');
                });

            });

            // смена, выбор хар-тики
            body.on('change','select.feature', function (){

                let row = $(this).closest("*[data-repeater-list]");

                getFeatureValues($(this).val(), function (data){
                    let feature_value = row.find('.preview__feature-value');
                    feature_value.empty().append(data);
                    reinitSelect();

                })
            });


            // получение значений выбранной хар-ки
            let getFeatureValues = function (feature_id, callback){
                let sendData = {
                    url: '{{route('get-feature-values')}}',
                    data: { feature_id: feature_id},
                    type:'POST',
                }
                $.sendAjax(sendData,function (response){
                    callback(response);
                });
            }

            // получение списка хар-тик
            let getFeature = function (callback){
                let sendData = {
                    url: '{{route('get-features')}}',
                    data: { entity_id: '{{$id}}', product_category_id: product_category_id ?? null },
                    type:'POST',
                }
                $.sendAjax(sendData,function (response){
                    callback(response);
                });
            }

            let reinitSelect = function (){
                let select = $('.select2.repeat');
                select.select2({
                    theme: 'bootstrap',
                    width: '100%',
                    placeholder: "{{__('cms.select.default')}}",
                });
            }

            let toggleLabel = function (status) {
                if(status === 'show') {
                    body.find('.label').map(function (idx, label){
                        if($(label).hasClass('hidden'))
                            $(label).removeClass('hidden');
                    })
                }
                if(status === 'hide'){
                    body.find('.label').map(function (idx, label){
                        if(!$(label).hasClass('hidden'))
                            $(label).addClass('hidden');
                    })
                }
            }
        })

    </script>
@endpush
