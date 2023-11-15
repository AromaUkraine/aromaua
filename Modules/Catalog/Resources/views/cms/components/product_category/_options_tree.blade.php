
@if($category->children && $category->children->count())

    <option class="ml-{{$level}}  " value="{{$category->id}}" {{$setSelected($category)}}> {!! $category->name !!}  </option>
    @foreach($category->children as $children)
        @include('catalog::cms.components.product_category._options_tree',['category'=>$children, 'level'=>1])
    @endforeach
@else
    <option class="ml-{{$level}} @if(!$category->parent)  @endif" value="{{$category->id}}" {{$setSelected($category)}}> {!! $category->name !!}  </option>
@endisset


