<tr style="border-bottom: 1px solid var(--line);">
    <td style="padding: 1rem;">{{ $category->id }}</td>
    <td style="padding: 1rem;">
        <div style="padding-left: {{ $level * 2 }}rem;">
            {{ $category->name }}
        </div>
    </td>
    <td style="padding: 1rem;">
        {{ $category->parent ? $category->parent->name : '—' }}
    </td>
    <td style="padding: 1rem;">{{ $category->products_count ?? $category->products()->count() }}</td>
    <td style="padding: 1rem; text-align: right;">
        <div style="display: flex; gap: 0.5rem; justify-content: flex-end; align-items: center;">
            <a href="{{ route('categories.edit', $category) }}" class="btn btn-ghost" style="padding: 0.5rem 1rem; font-size: 0.875rem;">
                Edit
            </a>
            <form action="{{ route('categories.destroy', $category) }}" method="POST" style="display: inline-block;" 
                  onsubmit="return confirm('Are you sure you want to delete this category? This action cannot be undone.');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn" style="padding: 0.5rem 1rem; font-size: 0.875rem; background-color: #dc3545; color: white; border: none;">
                    Delete
                </button>
            </form>
        </div>
    </td>
</tr>
@foreach($categories->where('parent_id', $category->id)->sortBy('name') as $childCategory)
    @include('categories.partials.category-row', ['category' => $childCategory, 'categories' => $categories, 'level' => $level + 1])
@endforeach
