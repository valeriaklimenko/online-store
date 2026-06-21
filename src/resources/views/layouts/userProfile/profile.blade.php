@extends('layouts.app')

@php
    /** @var \App\Models\User $user */
@endphp

@section('title', 'Profile — ' . $user->name)

@section('content')
    <section class="profile-grid">
        @include('partials.profile.settings-card', [
            'user' => $user,
            'eyebrow' => 'Customer',
            'allowDelete' => true,
        ])

        <article class="card profile-menu-card">
            <h2>My account</h2>
            <ul class="profile-menu">
                <li>
                    <a href="{{ route('basket.index') }}">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                  d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        <span>Basket</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('favorites.index') }}">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                  d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                        <span>Favorites</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('home') }}">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                  d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        <span>Continue shopping</span>
                    </a>
                </li>
            </ul>
        </article>
    </section>

@endsection
