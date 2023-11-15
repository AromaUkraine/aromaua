<?php


namespace App\Traits;


trait Sortable
{


    public function sortable(?array $orders)
    {

        if (!count($orders))
            return ['null'];
        try {

            \DB::beginTransaction();

            foreach ($orders as $order) {

                if (!isset($order['id']) || !isset($order['order']) || empty($order['id']) || empty($order['order']))
                    continue;

                $this::where('id', $order['id'])->update(['order' => $order['order']]);
            }

            \DB::commit();

            return response()->json(['message' => __('toastr.updated.message')]);
        } catch (\Exception $e) {

            \DB::rollback();
            return $e->getMessage();
        }
    }

    protected static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $model->order = self::max('order') + 1;
        });
    }
}
