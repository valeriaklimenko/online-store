{{--@php--}}
{{--    $children = $categories->where('parent_id', $category->id)->sortBy('order')->sortBy('name');--}}
{{--    $isActive = optional($activeCategory)->id === $category->id;--}}
{{--    $paddingLeft = $level > 0 ? ($level * 1.25 . 'rem') : null;--}}
{{--@endphp--}}

{{--<a--}}
{{--    href="{{ route('home', ['category' => $category->slug]) }}"--}}
{{--    class="catalog-item {{ $isActive ? 'is-active' : '' }}"--}}
{{--    @if($paddingLeft) style="padding-left: {{ $paddingLeft }};" @endif--}}
{{-->--}}
{{--    {{ $category->name }}--}}
{{--</a>--}}

{{--@foreach($children as $child)--}}
{{--    @include('partials.category-item', ['category' => $child, 'categories' => $categories, 'activeCategory' => $activeCategory, 'level' => $level + 1])--}}
{{--@endforeach--}}

