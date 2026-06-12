@extends('layouts.app')

@php
    /** @var \App\Models\User $user */
@endphp

@section('title', 'Profile — ' . $user->name)

@section('content')
    @if(session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    <section class="profile-grid">
        <article class="card profile-card">
            <p class="overline">Klavera team</p>
            <span class="badge">Administrator</span>
            <h2 class="profile-prefs__title">My preferences <span class="profile-prefs__arrow" aria-hidden="true">→</span></h2>

            <div class="profile-prefs-box profile-data-section">
                <div class="profile-data-item">
                    <div class="profile-data-label">Username</div>
                    <div class="profile-data-value">{{ $user->name }}</div>
                    <button type="button" class="btn btn-ghost btn-small" onclick="toggleEditName()">Change name</button>
                </div>
                <div class="profile-data-item">
                    <div class="profile-data-label">Email</div>
                    <div class="profile-data-value">{{ $user->email }}</div>
                    <button type="button" class="btn btn-ghost btn-small" onclick="toggleEditEmail()">Change email</button>
                </div>
            </div>

            <div class="profile-data-item" style="padding: 1.25rem 0 0; border: none;">
                <a href="{{ route('changePasswordForm') }}" class="btn btn-ghost btn-small">Change password</a>
            </div>

            <div class="account-actions" style="grid-template-columns: 1fr;">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-ghost">Log out</button>
                </form>
            </div>
        </article>

        <article class="card profile-menu-card">
            <h2>Control panel</h2>
            <ul class="profile-menu">
                <li>
                    <a href="{{ route('products.index') }}">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                        <span>Product management</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('managers.index') }}">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        <span>Manager team</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('manage.orders.index') }}">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                        <span>Order management</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('categories.index') }}">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                        <span>Categories</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.banner.edit') }}">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        <span>Homepage banner</span>
                    </a>
                </li>
            </ul>
        </article>
    </section>

    <div class="settings-modal" id="editNameModal">
        <div class="settings-modal-content">
            <div class="settings-modal-header">
                <h2>Change name</h2>
                <button type="button" class="close-modal" onclick="toggleEditName()" aria-label="Close">&times;</button>
            </div>
            <form method="POST" action="{{ route('updateProfile') }}" class="form-stack">
                @csrf
                @method('PATCH')
                <input type="hidden" name="update_field" value="name">
                <div class="form-field">
                    <label for="name">Name</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                </div>
                <div class="form-actions">
                    <button type="button" class="btn btn-ghost" onclick="toggleEditName()">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>

    <div class="settings-modal" id="editEmailModal">
        <div class="settings-modal-content">
            <div class="settings-modal-header">
                <h2>Change email</h2>
                <button type="button" class="close-modal" onclick="toggleEditEmail()" aria-label="Close">&times;</button>
            </div>
            <form method="POST" action="{{ route('updateProfile') }}" class="form-stack">
                @csrf
                @method('PATCH')
                <input type="hidden" name="update_field" value="email">
                <div class="form-field">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                </div>
                <div class="form-actions">
                    <button type="button" class="btn btn-ghost" onclick="toggleEditEmail()">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>

    <div class="settings-modal" id="emailChangeVerificationModal">
        <div class="settings-modal-content">
            <div class="settings-modal-header">
                <h2>Email verification required</h2>
                <button type="button" class="close-modal" onclick="toggleEmailChangeVerification()" aria-label="Close">&times;</button>
            </div>
            <div class="form-stack">
                <p>Please check your inbox to verify your new email address.</p>
                <div class="form-actions">
                    <button type="button" class="btn btn-primary btn-full" onclick="toggleEmailChangeVerification()">Got it</button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function toggleEditName() { document.getElementById('editNameModal').classList.toggle('active'); }
            function toggleEditEmail() { document.getElementById('editEmailModal').classList.toggle('active'); }
            function toggleEmailChangeVerification() { document.getElementById('emailChangeVerificationModal').classList.toggle('active'); }

            document.addEventListener('click', (event) => {
                ['editNameModal', 'editEmailModal', 'emailChangeVerificationModal'].forEach((id) => {
                    const modal = document.getElementById(id);
                    if (modal?.classList.contains('active') && event.target === modal) modal.classList.remove('active');
                });
            });

            @if(session('email_change_pending'))
            document.addEventListener('DOMContentLoaded', toggleEmailChangeVerification);
            @endif
        </script>
    @endpush
@endsection
