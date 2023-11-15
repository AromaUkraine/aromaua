<?php

namespace Modules\Synchronize\Console;

use App\Models\Page;

use Illuminate\Console\Command;
use App\Traits\ConsoleMessageTrait;
use Modules\Catalog\Entities\EntityFeature;
use Modules\Catalog\Entities\Feature;
use Modules\Catalog\Entities\FeatureKind;
use Modules\Catalog\Entities\FeatureKindTranslation;
use Modules\Catalog\Entities\FeatureTranslation;
use Modules\Catalog\Entities\FeatureValue;
use Modules\Catalog\Entities\FeatureValueTranslation;
use Modules\Catalog\Entities\Product;
use Modules\Catalog\Entities\Currency;
use Modules\Catalog\Entities\PriceType;
use Modules\Catalog\Entities\ProductPrice;
use Modules\Catalog\Entities\ProductCategory;
use Modules\Synchronize\Entities\Synchronize;
use Modules\Documentation\Entities\Documentation;
use Modules\Synchronize\Entities\SynchronizeTranslation;
use Modules\Documentation\Entities\DocumentationTranslation;
use Modules\Synchronize\Entities\ProductDocument;
use Modules\Synchronize\Entities\ProductDocumentTranslation;
use Modules\Synchronize\Entities\ProductProductCategoryPrice;
use Modules\Synchronize\Entities\ProductProductCategoryPriceTranslation;


class SynchronizeReset extends Command
{
    use ConsoleMessageTrait;
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'remote-data:reset';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Очистить данные загруженные из удаленной базы.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
            // category
            $this->truncate(ProductCategory::class);
            // products
            $this->truncate(Product::class);
            // currency, pricetype
//            $this->truncate(Currency::class);
//            $this->truncate(PriceType::class);
            // product-prices
            $this->truncate(ProductProductCategoryPrice::class);
            $this->truncate(ProductProductCategoryPriceTranslation::class);
            // documents
            $this->truncate(ProductDocument::class);
            $this->truncate(ProductDocumentTranslation::class);
            // feature
            $this->truncate(EntityFeature::class);
            $this->truncate(FeatureValueTranslation::class);
            $this->truncate(FeatureValue::class);
            $this->truncate(FeatureTranslation::class);
            $this->truncate(Feature::class);
            $this->truncate(FeatureKindTranslation::class);
            $this->truncate(FeatureKind::class);
            // category
            $this->resetPage([ProductCategory::class]);
            // products
            $this->resetPage([Product::class]);

            $this->message('Reset data from database completed');
        // try {

        //     \DB::beginTransaction();

        //     $this->truncate(ProductCategory::class);
        //     $this->truncate(Product::class);
        //     $this->truncate(Currency::class);
        //     $this->truncate(PriceType::class);

        //     $this->truncate(ProductProductCategoryPrice::class);
        //     $this->truncate(ProductProductCategoryPriceTranslation::class);

        //     $this->truncate(ProductDocument::class);
        //     $this->truncate(ProductDocumentTranslation::class);

        //     $this->resetPage([ProductCategory::class, Product::class]);

        //     \DB::commit();

        //     $this->message('Reset data from database completed');

        // } catch (\Exception $e) {

        //     \DB::rollback();
        //     \Log::error($e->getMessage());
        // }



    }

    /**
     * @param $class
     * @param int $autoincrement
     */
    protected function truncate($class, $autoincrement = 0)
    {
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        \DB::table($this->getTable($class))->truncate();
        $this->setAutoIncrement($class, $autoincrement);

        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }

    /**
     * @param array|string $classes
     */
    private function resetPage($classes)
    {
        if (is_array($classes)) {
            Page::whereIn('pageable_type', $classes)->forceDelete();
        } else {
            Page::where('pageable_type', $classes)->forceDelete();
        }
    }

    protected function getTable($class)
    {
        return (new $class)->getTable();
    }


    protected function setAutoIncrement($class, $value)
    {
        \DB::statement("ALTER TABLE {$this->getTable($class)} AUTO_INCREMENT = {$value};");
    }
}
