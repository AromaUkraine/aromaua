
<x-tab-lang :model="$article" rel="page" >

    @slot('language_switcher')
        <x-switcher
            :model="$article"
            rel="page"
            name="publish"
            lang
            label="{{ __('cms.publish') }}"
            options="{!! json_encode(['class'=>'float-right']) !!}"
        ></x-switcher>
    @endslot

    <x-input
        :model="$article"
        rel="page"
        name="name"
        lang
        label="{{__('page.name')}}"
        options="{!! json_encode(['maxlength'=>255, 'placeholder'=>__('page.name'), 'required'=>true ]) !!}"
    ></x-input>

    <x-slug-generator
        :model="$article"
        rel="page"
        name="slug"
        lang
        label="{{__('cms.slug')}}"
        watch="name"
        options="{!! json_encode(['maxlength'=>255, 'placeholder'=>__('cms.slug'), 'required'=>true ]) !!}"
    >
    </x-slug-generator>

    @if($categories->count())
        <div class="form-group">
            <select name="categories[]" placeholder="Select" class="select2 form-control" multiple  id="">
                @foreach($categories as $category)
                    @if($article && in_array($category->id, $article->categories->pluck('id')->toArray()))
                        <option value="{{ $category->id }}" selected>{{ $category->page->name }}</option>
                    @else
                        <option value="{{ $category->id }}" >{{ $category->page->name }}</option>
                    @endif
                @endforeach
            </select>
        </div>
    @endif

    <x-date-picker
        :model="$article"
        name="published_at"
        label="{{__('article.published')}}"
        options="{!! json_encode([ 'placeholder'=>__('article.published') ]) !!}"
    >
    </x-date-picker>

    <x-textarea
        :model="$article"
        rel="page"
        name="description"
        lang
        label="{{__('page.description')}}"
    ></x-textarea>

    <x-editor
        :model="$article"
        rel="page"
        name="text"
        lang
        label="{{__('page.text')}}"
    ></x-editor>

    <x-seo-page :model="$article" rel="page"></x-seo-page>

</x-tab-lang>


@section('form-fixed-buttons')
    <x-button
        type="submit"
        class="primary text-capitalize my-2 mr-1"
        title="{{__('cms.buttons.save')}}"
    ></x-button>
    <x-action
        href="{{ route('module.article.index', $page->id) }}"
        class="light text-capitalize my-2"
        title="{{__('cms.buttons.cancel')}}"
    ></x-action>
@endsection


