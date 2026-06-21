@if(empty($isNewCollectionFilter))
    @if($banner?->image)
        <section
            class="klavera-hero"
            style="background-image: url('{{ asset('storage/' . $banner->image) }}');"
            aria-label="Featured collection"
        >
            <div class="klavera-hero__content">
                @if($banner->title)
                    <h1 class="klavera-hero__title">{{ $banner->title }}</h1>
                @endif
                <a href="{{ route('home', ['new_collection' => 1]) }}#products" class="klavera-hero__cta">Shop now</a>
            </div>
        </section>
    @else
        <section class="klavera-hero klavera-hero--placeholder" aria-label="Featured collection">
            <div class="klavera-hero__content">
                <h1 class="klavera-hero__title">Klavera</h1>
                <a href="{{ route('home', ['new_collection' => 1]) }}#products" class="klavera-hero__cta" style="color: var(--text); border-color: var(--text);">Shop now</a>
            </div>
        </section>
    @endif
@endif
