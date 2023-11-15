
<x-drag-drop-left-right
    name="feature_id"
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
    'maxHeight' => ($options['maxHeight']) ?? null,
]) !!}"></x-drag-drop-left-right>
