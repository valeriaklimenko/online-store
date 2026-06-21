@extends('layouts.app')

@php
    /** @var \App\Models\User $authUser */
    $authUser = auth()->user();
@endphp

@section('title', 'Manager Dashboard — Klavera')

@section('content')
    <div class="page-head">
        <div>
            <p class="overline">Control panel</p>
            <h1 class="section-title">Manager dashboard</h1>
            <p class="form-help">Welcome, {{ $authUser->name }}.</p>
        </div>
        <a href="{{ route('manager.profile') }}" class="btn btn-ghost">My profile</a>
    </div>

    <div class="dashboard-grid">
        <div class="dashboard-tile">
            <h3>Product management</h3>
            <p>Add, edit and remove products in the catalog.</p>
            <a href="{{ route('products.index') }}" class="btn btn-primary">Go to products</a>
        </div>
        <div class="dashboard-tile">
            <h3>New product</h3>
            <p>Quickly add an item to the storefront.</p>
            <a href="{{ route('products.create') }}" class="btn btn-ghost">Add product</a>
        </div>
    </div>
@endsection
