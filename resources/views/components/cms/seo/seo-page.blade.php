<x-input
    :model="$model"
    name="h1"
    lang
    label="{{__('seo.h1')}}"
    options="{!! json_encode(['maxlength'=>255, 'placeholder'=>__('seo.h1')]) !!}"
></x-input>

<x-input
    :model="$model"
    name="title"
    lang
    label="{{__('seo.title')}}"
    options="{!! json_encode(['maxlength'=>255, 'placeholder'=>__('seo.title')]) !!}"
></x-input>

<x-input
    :model="$model"
    name="breadcrumbs"
    lang
    label="{{__('seo.breadcrumbs')}}"
    options="{!! json_encode(['maxlength'=>255, 'placeholder'=>__('seo.breadcrumbs')]) !!}"
></x-input>

<x-input
    :model="$model"
    name="meta_description"
    lang
    label="{{__('seo.meta_description')}}"
    options="{!! json_encode(['maxlength'=>255, 'placeholder'=>__('seo.meta_description')]) !!}"
></x-input>

<x-input
    :model="$model"
    name="meta_keywords"
    lang
    label="{{__('seo.meta_keywords')}}"
    options="{!! json_encode(['maxlength'=>255, 'placeholder'=>__('seo.meta_keywords')]) !!}"
></x-input>

<x-input
    :model="$model"
    name="anchor"
    lang
    label="{{__('seo.anchor')}}"
    options="{!! json_encode(['maxlength'=>255, 'placeholder'=>__('seo.anchor')]) !!}"
></x-input>
