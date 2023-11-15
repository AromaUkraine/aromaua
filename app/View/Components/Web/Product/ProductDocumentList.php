<?php

namespace App\View\Components\Web\Product;

use Illuminate\View\Component;
use Modules\Synchronize\Entities\ProductDocument;



class ProductDocumentList extends Component
{
    public $product;

    public $columns;

    public $documents;

    public $langs = [];

    private $category;
    /**
     * Create a new component instance.
     *
     * @param object|null $product
     */
    public function __construct($product, $category)
    {
        // $this->modify_data = $product->modify_data ?? null;
        $this->product = $product;
        $this->category = $category;
        $this->setColumns();
        $this->setDocuments();
//        dd($this->documents);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.web.product.product-document-list');
    }


    public function getProductCode()
    {
        return $this->product->product_code ?? '';
    }

    /**
     * Проверяет существует ли раздел документации и в нем есть хотя бы один массив с записями
     *
     * @return bool
     */
    public function issetDocumentation()
    {
        return !!$this->documents->count();
    }

    private function setColumns()
    {
        if ($this->product->is_flavoring == 0) {
            $this->columns = $this->product->columns ?? null;
        } else {
            $this->columns = [];//$this->product->columns ?? null;
            foreach ($this->product->columns as $key => $column) {
                if ($key == 0) {
                    $this->columns[0] = $column;
                } else {
                    if (!empty($column['price'])) {
                        $this->columns[0]['price'] = $column['price'];
                        $this->columns[0]['currency'] = $column['currency'];
                    }
                }
            }
        }
    }

    private function setDocuments()
    {

        $this->documents = $this->product->documents->map(function(ProductDocument $document){
            if($document->translations->count()){

                $currLocale = app()->getLocale();
                $result = [
                    'column_number' => $document->column_number,
                    'serial_number' => $document->serial_number,
                ];

                $translationData = $document->translations->toArray();

                foreach ($translationData as $translation) {
                    if (!in_array($translation['locale'], $this->langs)) {
                        $this->langs[] = $translation['locale'];
                    }
                    if ($translation['locale'] == $currLocale) {
                        $result['name'] = $translation['name'];
                    }
                    $result['locale'][$translation['locale']] = [
                        'locale' => $translation['locale'],
                        'name' => $translation['name'],
                        'href' => $translation['href'],
                        'date' => $translation['date'],
                        'publish' => $translation['publish'],
                    ];
                }

                return $result;
            }
        })->groupBy(['column_number']);

    }


    public function getDocumentsByColumnNumber($column_number)
    {
        return $this->documents[$column_number] ?? [];
    }


    private function getCurrentLocale()
    {
        $locale = app()->getLocale();

        // если язык сайта - украинский и в массиве документации существует ключ языка ua -
        // устанавливает текущий язык как ua.
        // если такого ключа нет - проверяем есть ли документация с ключем uk
        // если же и такого нет - устанавливаем текущий язык - ru
        if($locale == 'ua'):
            if($this->documents->offsetExists('ua')):
                $current_locale = 'ua';
            else:
                $current_locale = 'ru';
            endif;

        // Если язык сайта отличный от украинского - проверяем есть ли ключ этого
        // языка в массиве с документацией если есть - указываем текущий язык как локаль иначе
        // проверяем есть ли ключ языка ru и если есть устанавливаем его как текущий
        // иначе берем самый первый ключ из массива документации и его устанавливаем как текущий
        else:
            if($this->documents->offsetExists($locale)):
                $current_locale = $locale;
            elseif($this->documents->offsetExists('ru')):
                $current_locale = 'ru';
            else:
                $firstValue = reset($this->documents);
                $current_locale = key($firstValue);
            endif;
        endif;

        return $current_locale;
    }


}
