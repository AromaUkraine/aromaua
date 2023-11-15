<?php


namespace App\Traits;

use Yajra\DataTables\Html\Column;

trait DataTableTrait
{

    protected $info = true;

    /**
     * Формируем Html таблицы
     * @return mixed
     */
    public function html()
    {

        return $this->builder()
            ->setTableId($this->getTableId())
            ->paging($this->getPaging())
            ->pageLength($this->getPageLength())
            ->lengthMenu($this->getLengthMenu())
            ->columns($this->getColumns())
            ->language($this->getLanguage())
            ->setTableAttributes($this->getTableAttributes())
            ->info($this->getInfo())
            ->minifiedAjax()
            ->drawCallback($this->getDrawCallback())
            //            ->parameters([
            //                'order'=>[1,'desc'],
            //            ])
            //->initComplete($this->initComplete())
            ->dom($this->getDom());
    }


    /**
     *  Показать, спрятать информацию о кол-ве записей
     * @return bool
     */
    public function getInfo()
    {
        return $this->info;
    }

    //@todo написать правило включения пагинации
    public function getPaging()
    {
        if (isset($this->paging)) {
            return $this->paging;
        } else if (isset($this->totalCount) && $this->totalCount > $this->getLengthMenu()[0]) {
            return true;
        }
        return false;
    }

    /**
     * Добавляет аттрибуты для таблицы (class, data-attribute, etc.)
     * @return array
     */
    public function getTableAttributes()
    {
        if (isset($this->attributes)) {
            return $this->attributes;
        }
        return [];
    }

    /**
     * Возвращает Id таблицы
     * @return string
     */
    public function getTableId()
    {

        if (isset($this->table_id)) {
            return $this->table_id;
        }

        return \Str::kebab(class_basename(__CLASS__));
    }


    /**
     * Устанавливает количество отображаемых элементов на странице
     * @return int
     */
    public function getPageLength()
    {

        return \Session::get('element_per_page') ?? 15;
        //        if (isset($this->element_per_page)) {
        //            return $this->element_per_page;
        //        }
        //
        //        return 15;
    }

    /**
     * Создает выпадающий список с вариантами количества отображаемых элементов на странице
     * @return array|int[]
     */
    public function getLengthMenu()
    {
        if (isset($this->length_menu) && is_array($this->length_menu)) {
            return $this->length_menu;
        }

        return [5, 10, 15, 25, 50, 100, 150, 200];
    }

    /**
     * Метод добавляет скрипты в основной скрипт отрисованной таблицы
     * @return string
     */
    public function getDrawCallback()
    {
        if (isset($this->draw_callback) && is_string($this->draw_callback)) {
            return $this->draw_callback;
        }

        return "function(){
            let table = this;
            {$this->getConfirmDeleteScript()}
            {$this->getToggleEnabledScript()}
            {$this->getToggleCheckedScript()}
            {$this->getToggleAllCheckedScript()}
            {$this->getToggleRadioButtonScript()}
            {$this->sendAjaxScript()}
       }";
    }



    /**
     * Формирует DOM таблицы и элементов таблицы (фильтр, пагинация, инфо и т.п.)
     * @return string
     */
    public function getDom()
    {
        if (isset($this->dom) && is_string($this->dom)) {
            return $this->dom;
        }

        return "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>
                <'row'<'col-sm-12 mb-1 table-responsive'tr>>
                <'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>";
    }

    /**
     * Возвращает json переводов элементов таблицы
     * @return string
     */
    public function getLanguage()
    {
        if (isset($this->translate) && is_string($this->translate)) {
            return $this->translate;
        }

        return asset('/vendors/datatables/lang/' . \App::getLocale() . '.json');
    }

    /**
     * Инициализация tooltip
     * @return string
     */
    public function getTooltipScript()
    {
        return "$('[data-toggle=\"tooltip\"]').tooltip();";
    }

    public function getToggleEnabledScript()
    {
        return "
            let enableBtn = $('[data-action=\"enabled\"]', table);
            enableBtn.click(function(e){
               e.preventDefault();
               $(this).addClass('disabled');
               let url = $(this).attr('href');
               sendAjax(url, 'POST', {}, function(response){
                   toastr.success(response.message, response.title);
               })
            })
        ";
    }



    public function getToggleCheckedScript()
    {
        return "
            let label = $('[data-toggle=\"checked\"]', table);
            label.click(function(e){
               let url = $(this).attr('data-url');
               let data = {
                    url: $(this).attr(\"data-url\"),
                    data: {'params':$(this).attr(\"data-params\")},
                    'type':'POST',
                    'dataType':'json'
               }
               $.sendAjax(data, function(response){
                   window.LaravelDataTables[table.attr('id')].ajax.reload();
                   toastr.success(response.message, response.title);
               })
            })
        ";
    }

    protected function getToggleAllCheckedScript()
    {
        return "
            let labelAll = $('[data-toggle=\"checked-all\"]', table);
            labelAll.click(function(e){
               console.log('toggle');
            })
        ";
    }

    public function getToggleRadioButtonScript()
    {
        return "
            let radioButtons = $('.toggle_radio_button', table);

            radioButtons.change(function (e){
                let checked = radioButtons.filter(function (idx, item){
                     return $(item).prop('checked');
                });
                let sendData = {
                     url: checked.data('url'),
                     data: { parent_before: checked.data('before'), parent_now :  checked.data('now')},
                     type:'POST',
                     dataType:'json'
                }
                $.sendAjax(sendData, function(response){
                    window.LaravelDataTables[table.attr('id')].ajax.reload();
                     toastr.success(response.message, response.title);
                })
            });

        ";
    }

    /**
     * Подтверждение удаления
     * @return string
     */
    public function getConfirmDeleteScript()
    {
        return "
            let deleteBtn = $('[data-action=\"delete\"]', table);
            deleteBtn.click(function(e){
                e.preventDefault();
                $(this).addClass('disabled');
                let url = $(this).attr('href');

                Swal.fire({
                    title: '" . __('datatable.delete.title') . "',
                    html: '" . __('datatable.delete.text') . "',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: '" . __('datatable.delete.confirmButtonText') . "',
                    cancelButtonText: '" . __('datatable.delete.cancelButtonText') . "',
                    confirmButtonClass: 'btn btn-danger',
                    cancelButtonClass: 'btn btn-light ml-1',
                    buttonsStyling: false,
                }).then(function (result) {
                    if(result.value){
                       sendAjax(url, 'DELETE', {}, function(response){
                           toastr.success(response.message, response.title);
                       })
                    }else{
                        $(deleteBtn).removeClass('disabled');
                    }
                })
            })";
    }


    public function sendAjaxScript()
    {
        return "
            function sendAjax(url, type, data = {}, callback){
                data._token = document.head.querySelector('meta[name=\"csrf-token\"]').getAttribute('content');
                $.ajax({
                    url: url,
                    type: type,
                    data: data,
                    dataType: 'JSON',
                    success: function(res){
                        window.LaravelDataTables[table.attr('id')].ajax.reload();
                        callback(res);
                    }
                })
            }
        ";
    }

    /**
     * Формирование колонок (создание объектов класа Column) из массива columns
     * @return array
     */
    public function getColumns()
    {
        if (isset($this->columns) && is_array($this->columns)) {
            $data = [];

            foreach ($this->columns as $k => $column) {
                foreach ($column as $key => $value) {
                    if ($key == 'data') {

                        if (key_exists('name', $column)) {
                            $col = Column::make($value, $column['name']);
                            unset($column['name']);
                        } else {
                            $col = Column::make($value);
                        }

                        if (key_exists('title', $column)) {
                            $col->title(__($column['title']));
                        } else {
                            $col->title($column['data']);
                        }

                        if (key_exists('orderable', $column)) {
                            $col->orderable($column['orderable']);
                        }

                        if (key_exists('searchable', $column)) {
                            $col->searchable($column['searchable']);
                        }

                        if (key_exists('exportable', $column)) {
                            $col->exportable($column['exportable']);
                        }

                        if (key_exists('printable', $column)) {
                            $col->printable($column['printable']);
                        }

                        if (key_exists('footer', $column)) {
                            $col->footer($column['footer']);
                        }

                        if (key_exists('titleAttr', $column)) {
                            $col->titleAttr($column['titleAttr']);
                        } else {
                            $col->titleAttr('');
                        }

                        $data[$k] = $col;
                    }
                }
            }
            $data[] = Column::computed('action')
                ->title('')
                ->exportable(false)
                ->printable(false)
                ->addClass('text-center text-nowrap');
            return $data;
        }
    }

    public function link($link, $name, $attributes = [])
    {
        $add = '';
        foreach ($attributes as $key => $value) {
            $add .= $key . "='$value'";
        }

        return "<a href='" . $link . "' $add> $name </a>";
    }

    public function getOrderColumn($icon = 'bx bx-move-vertical move')
    {
        return ($this->totalCount > 1) ? "<i class='{$icon}'></i>" : '';
    }

    public function badge($value, $class = 'light-secondary', $content = null)
    { //badge-success
        $class = "badge badge-pill badge-{$class} mr-1 mb-1 ";

        if ($content) {
            $value = $content;
        }
        return "<div class='{$class}'>{$value}</div>";
    }

    public function checkbox($name, $data, $checked_param = null, $route = null, $disabled = 'readonly')
    {
        if (!$route)
            $route = route('checked');

        if (!$checked_param) {
            $checked = ($data->$name) ? 'checked' : '';
        } else {
            $checked = 'checked';
        }

        $id = $name . $data->id;
        $params = json_encode([
            'table' => get_class($data),
            'field' => $name,
            'id' => $data->id
        ]);

        return "<fieldset class='mb-0'>
            <div class='checkbox checkbox-primary checkbox-glow'>
                <input type='checkbox' id='{$id}' name='{$name}' {$checked} {$disabled}>
                <label for='{$id}' data-params='{$params}' data-toggle='checked' data-url='{$route}'></label>
            </div>
        </fieldset>";
    }

    public function radioButton($id, $checked_id, $route = null)
    {
        if (!$route)
            $route = route('radio');

        $checked = ($checked_id == $id) ? 'checked' : '';

        return "<fieldset>
            <div class='radio radio-primary radio-glow'>
                <input type='radio'
                   id='item_{$id}'
                   name='radio_button'
                   class='toggle_radio_button'
                   data-before='{$checked_id}'
                   data-now='{$id}'
                   data-url='{$route}'
                   {$checked}
                >
                <label for='item_{$id}'></label>
            </div>
        </fieldset>";
    }

}
