@if($category->children->count())
{{--    {{ dump($category->children) }}--}}
    optgroup {{' - '.$category->page->name}} <br>

    @each('catalog::cms.components.product_category.demo', $category->children, 'category')
{{--    @include('catalog::cms.components.product_category.demo',['category'=>$category->children])--}}
{{--    @foreach($category->children as $cat)--}}
{{--        optgroup {{' -- '.$cat->page->name}} <br>--}}
{{--        @isset($cat->children)--}}
{{--            @foreach($cat->children as $child)--}}
{{--                optgroup {{' --- '.$child->page->name}} <br>--}}
{{--            @endforeach--}}
{{--        @endisset--}}
{{--    @endforeach--}}
{{--        @include('catalog::cms.components.product_category.demo',['category'=>$category->children])--}}
@else
    {{ $category->page->name }}
    @foreach($category as $finish)
         ---- {{$finish}}  <br>
    @endforeach
@endif

