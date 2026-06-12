@extends('layouts.app')

@section('title', 'Homepage Banner — Klavera')

@section('content')
    <div class="page-head">
        <div>
            <p class="overline">Storefront</p>
            <h1 class="section-title">Homepage Banner</h1>
            <p class="form-help">Upload the hero image and set the title. The button text is always SHOP NOW.</p>
        </div>
        <a href="{{ route('admin.profile') }}" class="btn btn-ghost">← Back to profile</a>
    </div>

    @if(session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul style="margin: 0; padding-left: 1.2rem;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card">
        <form action="{{ route('admin.banner.update') }}" method="POST" enctype="multipart/form-data" class="form-stack">
            @csrf

            <div class="form-field">
                <label for="title">Banner title *</label>
                <input type="text" id="title" name="title" value="{{ old('title', $banner?->title) }}" required
                       placeholder="The Story of Summer — POLLINATE">
                <p class="form-help">This text appears over the banner image on the homepage.</p>
            </div>

            <div class="form-field">
                <label for="image">Banner image</label>
                @if($banner?->image)
                    <div style="margin-bottom: 1rem;">
                        <img src="{{ asset('storage/' . $banner->image) }}" alt="Current banner"
                             style="max-width: 100%; max-height: 280px; object-fit: cover; border: 1px solid var(--line-dark);">
                    </div>
                @endif
                <input type="file" id="image" name="image" accept="image/jpeg,image/png,image/jpg,image/webp">
                <p class="form-help">Recommended: wide landscape photo (at least 1920×900). Max 8 MB.</p>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Save Banner</button>
                <a href="{{ route('home') }}" class="btn btn-ghost" target="_blank">Preview homepage</a>
            </div>
        </form>
    </div>
@endsection
