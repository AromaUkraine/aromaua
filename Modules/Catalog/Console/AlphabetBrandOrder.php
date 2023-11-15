<?php

namespace Modules\Catalog\Console;

use App\Models\Alphabet;
use App\Models\Translations\AlphabetTranslation;
use App\Traits\ConsoleMessageTrait;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;
use Modules\Catalog\Entities\FeatureKind;
use Modules\Catalog\Entities\FeatureValue;
use Modules\Catalog\Entities\SeoCatalog;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class AlphabetBrandOrder extends Command
{
    use ConsoleMessageTrait;
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'alphabet:brand {--t=1}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Алфавит для брендов.';
    /**
     * @var string
     */
    private $locale;

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

        if (Schema::hasTable('alphabets')) {

            try {
                $this->option('t');
                AlphabetTranslation::truncate();
            }catch (\Exception $e){}

            $this->update();
        }

        $this->message('Alphabet updated successfully.');
    }


    protected function update()
    {
        $locales = config('translatable.locales');
        $alphabets = Alphabet::active()->get();

//        $total = $alphabets->count();

        try{
            \DB::beginTransaction();

            $alphabets->each(function ($alphabet, $index) use ( $locales ){

                // $this->process('alphabet with locale "'.$locale.'" ', $total, $index);
                foreach ($locales as $locale) {

                    $find = $this->findBrandByFirstSymbol($alphabet->symbol, $locale);

                    if(!$find->count()) :
                        $alphabet->update(['total'=>0]);
                    else:
                        $data = $this->setData($alphabet, $find, $locale);
                        $alphabet->update($data);
                    endif;
                }

            });



            \DB::commit();
        }catch (\Exception $e){

            \DB::rollback();
            dd($e->getMessage());
        }
    }



    protected function findBrandByFirstSymbol($symbol, $locale)
    {
        return (new FeatureValue())->valuesWithRelations(FeatureKind::IS_BRAND, $locale )
            ->addSelect('entity_features.id as entity_feature_id', 'entity_features.feature_value_id as entity_feature_feature_value_id')
            ->join('entity_features', function($join){
                $join->on('entity_features.feature_value_id','=','feature_values.id');
                $join->on('entity_features.feature_id','=','features.id');
            })
            ->join('seo_catalogs', function($join){
                $join->on('seo_catalogs.id','=','entity_features.entityable_id');
                $join->where('entityable_type',SeoCatalog::class);
            })
            ->where('seo_catalogs.is_brand',true)
            ->where('feature_value_translations.name','like', $symbol . "%")
            ->get();
    }


    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
//            ['--t', InputArgument::REQUIRED, 'An example argument.'],
        ];
    }

    public function demo()
    {
 //        return FeatureValue::select(
//            'feature_value_translations.id as fvt_id', 'feature_value_translations.*',
//            'feature_values.*',
//            'feature_kinds.active as feature_kind_active', 'feature_kind_translations.name as feature_kind_name', 'feature_kind_translations.publish as feature_kind_publish',
//            'features.id as feature_id', 'features.active as feature_active', 'feature_translations.name as feature_name', 'feature_translations.publish as feature_publish',
//            'entity_features.id as entity_feature_id', 'entity_features.feature_value_id as entity_feature_feature_value_id'
//        )
//            ->join('feature_value_translations', function ($join){
//                $join->on('feature_values.id','=','feature_value_translations.feature_value_id')
//                    ->where('publish', 1)->where('locale',$this->locale);
//            })
//            ->join('feature_kinds', function ($join){
//               $join->on('feature_values.feature_kind_id','=','feature_kinds.id');
//               $join->join('feature_kind_translations', function ($join){
//                   $join->on('feature_kinds.id','=','feature_kind_translations.feature_kind_id');
//               });
//            })
//            ->join('features', function ($join){
//                $join->on('features.feature_kind_id','=','feature_kinds.id');
//                $join->join('feature_translations', function ($join){
//                    $join->on('features.id','=','feature_translations.feature_id');
//                });
//            })
//            ->join('entity_features', function($join){
//                $join->on('entity_features.feature_value_id','=','feature_values.id');
//                $join->on('entity_features.feature_id','=','features.id');
//            })
//            ->join('seo_catalogs', function($join){
//                $join->on('seo_catalogs.id','=','entity_features.entityable_id');
//                $join->where('entityable_type',SeoCatalog::class);
//            })
//            ->where('feature_values.active', true)
//            ->where('feature_kinds.key', FeatureKind::IS_BRAND)
//            ->where('feature_kinds.active', true)
//            ->where('feature_kind_translations.publish', 1)
//            ->where('feature_kind_translations.locale',$this->locale)
//            ->where('features.active', true)
//            ->where('feature_translations.publish', true)
//            ->where('feature_translations.locale',$this->locale)
//            ->where('seo_catalogs.is_brand',true)
////            ->groupBy(['feature_values.id'])
//            ->get();

//        $brands = SeoCatalog::with(['entity_features'=>function($q){
//            $q->with(['feature'=>function($q){
//                $q->withAndWhereHas('feature_kind', function($q){
//                    $q->with('feature_values')->where('key', FeatureKind::IS_BRAND);
//                });
//            }]);
//        }])->where('is_brand', true)->get();
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['t', null, InputOption::VALUE_OPTIONAL, 'Truncate alphabet table', null],
        ];
    }

    private function makeData($find)
    {
        $find->map(function ($item) use(&$compare){
            $compare[] = [
                'feature_value_id'=>$item->id,
                'feature_kind_id'=>$item->feature_kind_id,
                'entity_feature_id'=>$item->entity_feature_id,
            ];
        });

        return json_encode($compare);
    }

    private function setData($alphabet, $find, $locale)
    {
        $data[$locale] = [
            'total'=>$alphabet->total + $find->count(),
            'data' => $this->makeData($find)
        ];

        return $data;
    }
}
