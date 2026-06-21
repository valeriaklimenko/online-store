@php
    /** @var \App\Models\Category $category */
    /** @var \Illuminate\Support\Collection<int, \App\Models\Category> $categories */
    /** @var int $level */
    $children = $categories->where('parent_id', $category->id)->sortBy('name');
    $hasChildren = $children->isNotEmpty();
    $productCount = $category->products_count ?? $category->products()->count();
@endphp
<li class="category-tree__item" data-level="{{ $level }}">
    <div class="category-tree__row">
        <div class="category-tree__name-wrap" style="padding-left: {{ $level * 1.25 }}rem;">
            @if($level > 0)
                <span class="category-tree__guides" aria-hidden="true">
                    @for($i = 0; $i < $level; $i++)
                        <span class="category-tree__guide {{ $i === $level - 1 ? 'category-tree__guide--last' : '' }}"></span>
                    @endfor
                </span>
            @endif
            <span class="category-tree__toggle {{ $hasChildren ? '' : 'category-tree__toggle--leaf' }}" aria-hidden="true">
                {{ $hasChildren ? '−' : '' }}
            </span>
            <h3 class="category-tree__name">{{ $category->name }}</h3>
        </div>
        <span class="category-tree__meta category-tree__meta--id">#{{ $category->id }}</span>
        <span class="category-tree__meta category-tree__meta--parent">
            {{ $category->parent ? $category->parent->name : 'Root' }}
        </span>
        <span class="category-tree__meta">{{ $productCount }} products</span>
        <div class="category-tree__actions">
            <a href="{{ route('categories.edit', $category) }}" class="btn btn-ghost btn-small">Edit</a>
            <form action="{{ route('categories.destroy', $category) }}" method="POST"
                  onsubmit="return confirm('Delete category «{{ $category->name }}»? This cannot be undone.');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-small">Delete</button>
            </form>
        </div>
    </div>
    @if($hasChildren)
        <ul class="category-tree__children">
            @foreach($children as $child)
                @include('categories.partials.category-tree-node', [
                    'category' => $child,
                    'categories' => $categories,
                    'level' => $level + 1,
                ])
            @endforeach
        </ul>
    @endif
</li>
