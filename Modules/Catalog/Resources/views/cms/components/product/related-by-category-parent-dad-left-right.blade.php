<x-drag-drop-left-right
    name="parent_product_id"
    options="{!! json_encode([
    'left'=>[
        'label' => __('cms.used'),
        'data'  => $used,
        'name' => 'used'
    ],
    'right'=>[
        'label' => __('cms.available'),
        'data'  => $available,
        'name' => 'available'
    ],
    'search'=>true,
    'fixed'=> $fixed,
    'height' => 600,
]) !!}"></x-drag-drop-left-right>
