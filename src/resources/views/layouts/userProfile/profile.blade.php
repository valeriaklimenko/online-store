@extends('layouts.app')

@php
    /** @var \App\Models\User $user */
@endphp

@section('title', 'Profile — ' . $user->name)

@section('content')
    @if(session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
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

    <section class="profile-grid">
        <article class="card profile-card">
            <p class="overline">Customer</p>
            <h2 class="profile-prefs__title">My preferences <span class="profile-prefs__arrow" aria-hidden="true">→</span></h2>

            <div class="profile-prefs-box profile-data-section">
                <div class="profile-data-item">
                    <div class="profile-data-label">Email</div>
                    <div class="profile-data-value">{{ $user->email }}</div>
                    <button type="button" class="btn btn-ghost btn-small" onclick="toggleEditEmail()">Change email</button>
                </div>
                <div class="profile-data-item">
                    <div class="profile-data-label">Name</div>
                    <div class="profile-data-value">{{ $user->name }}</div>
                    <button type="button" class="btn btn-ghost btn-small" onclick="toggleEditName()">Change name</button>
                </div>
            </div>

            <div class="profile-data-item" style="padding: 1.25rem 0 0; border: none;">
                <a href="{{ route('changePasswordForm') }}" class="btn btn-ghost btn-small">Change password</a>
            </div>

            <div class="account-actions">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-ghost">Log out</button>
                </form>
                <button type="button" class="btn btn-danger" onclick="toggleDeleteAccount()">Delete account</button>
            </div>
        </article>

        <article class="card profile-menu-card">
            <h2>My account</h2>
            <ul class="profile-menu">
                <li>
                    <a href="{{ route('basket.index') }}">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        <span>Basket</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('orders.index') }}">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                        <span>My orders</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('favorites.index') }}">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                        <span>Favorites</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('home') }}">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        <span>Continue shopping</span>
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
                <p class="form-help">Click the link in the email to complete the change.</p>
                <div class="form-actions">
                    <button type="button" class="btn btn-primary btn-full" onclick="toggleEmailChangeVerification()">Got it</button>
                </div>
            </div>
        </div>
    </div>

    <div class="settings-modal" id="deleteAccountModal">
        <div class="settings-modal-content">
            <div class="settings-modal-header">
                <h2>Delete account</h2>
                <button type="button" class="close-modal" onclick="toggleDeleteAccount()" aria-label="Close">&times;</button>
            </div>
            <form method="POST" action="{{ route('account.delete') }}" class="form-stack" id="deleteAccountForm">
                @csrf
                @method('DELETE')
                <p><strong>This action cannot be undone.</strong> Your basket, favorites, and account data will be permanently removed.</p>
                <p class="form-help">Enter your password to confirm.</p>
                <div class="form-field">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required autocomplete="current-password">
                    @error('password')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-actions">
                    <button type="button" class="btn btn-ghost" onclick="toggleDeleteAccount()">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete account</button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            function toggleEditName() {
                document.getElementById('editNameModal').classList.toggle('active');
            }

            function toggleEditEmail() {
                document.getElementById('editEmailModal').classList.toggle('active');
            }

            function toggleEmailChangeVerification() {
                document.getElementById('emailChangeVerificationModal').classList.toggle('active');
            }

            function toggleDeleteAccount() {
                const modal = document.getElementById('deleteAccountModal');
                modal.classList.toggle('active');
                if (!modal.classList.contains('active')) {
                    document.getElementById('deleteAccountForm').reset();
                }
            }

            document.addEventListener('click', (event) => {
                ['editNameModal', 'editEmailModal', 'emailChangeVerificationModal', 'deleteAccountModal'].forEach((id) => {
                    const modal = document.getElementById(id);
                    if (modal?.classList.contains('active') && event.target === modal) {
                        modal.classList.remove('active');
                    }
                });
            });

            @if(session('email_change_pending'))
            document.addEventListener('DOMContentLoaded', toggleEmailChangeVerification);
            @endif
        </script>
    @endpush
@endsection
