@php
    /** @var \Illuminate\Support\Collection|\Illuminate\Database\Eloquent\Collection $categories */
    $categories = $categories ?? collect();
    $parentId = $parentId ?? null;
    $level = $level ?? 0;
    $selectedId = $selectedId ?? null;

    $children = $categories
        ->where('parent_id', $parentId)
        ->sortBy('order')
        ->sortBy('name');
@endphp

@foreach ($children as $category)
    @php
        $prefix = $level > 0 ? str_repeat('— ', (int) $level) : '';
    @endphp
    <option value="{{ $category->id }}" @selected((string) $selectedId === (string) $category->id)>
        {{ $prefix }}{{ $category->name }}
    </option>
    @include('partials.category-options', [
        'categories' => $categories,
        'parentId' => $category->id,
        'level' => $level + 1,
        'selectedId' => $selectedId,
    ])
@endforeach
