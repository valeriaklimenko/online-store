@extends('layouts.app')

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
            <div class="profile-data-section">
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
                <div class="profile-data-item">
                    <a href="{{ route('changePasswordForm') }}" class="btn btn-ghost btn-small">Change password</a>
                </div>
                <div class="profile-data-item" style="margin-top: 1.5rem; padding-top: 1.5rem; border-top: 1px solid var(--border-color);">
                    <button type="button" class="btn btn-ghost btn-small" onclick="toggleDeleteAccount()" style="color: var(--error-color);">
                        Delete account
                    </button>
                </div>
            </div>
        </article>

        <article class="card profile-menu-card">
            <h2>My Account</h2>
            <ul class="profile-menu">
                <li>
                    <a href="{{ route('basket.index') }}">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        <span>Basket</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                        </svg>
                        <span>Current Orders</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                        </svg>
                        <span>Purchase History</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                        </svg>
                        <span>Payment Methods</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                        <span>Support</span>
                    </a>
                </li>
            </ul>
        </article>
    </section>

    <!-- Edit Name Form -->
    <div class="settings-modal" id="editNameModal">
        <div class="settings-modal-content">
            <div class="settings-modal-header">
                <h2>Change name</h2>
                <button class="close-modal" onclick="toggleEditName()">&times;</button>
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

    <!-- Edit Email Form -->
    <div class="settings-modal" id="editEmailModal">
        <div class="settings-modal-content">
            <div class="settings-modal-header">
                <h2>Change email</h2>
                <button class="close-modal" onclick="toggleEditEmail()">&times;</button>
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

    <!-- Email Change Verification Modal -->
    <div class="settings-modal" id="emailChangeVerificationModal">
        <div class="settings-modal-content">
            <div class="settings-modal-header">
                <h2>Email Verification Required</h2>
                <button class="close-modal" onclick="toggleEmailChangeVerification()">&times;</button>
            </div>
            <div class="form-stack">
                <p style="color: var(--text-main); margin-bottom: 1rem;">
                    Please check your email inbox to verify your new email address. We've sent a verification link to your new email address.
                </p>
                <p style="color: var(--text-muted); font-size: 0.9rem; margin-bottom: 1.5rem;">
                    Click on the verification link in the email to complete the email change process.
                </p>
                <div class="form-actions">
                    <button type="button" class="btn btn-primary btn-full" onclick="toggleEmailChangeVerification()">Got it</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Account Confirmation Modal -->
    <div class="settings-modal" id="deleteAccountModal">
        <div class="settings-modal-content">
            <div class="settings-modal-header">
                <h2>Delete Account</h2>
                <button class="close-modal" onclick="toggleDeleteAccount()">&times;</button>
            </div>
            <form method="POST" action="{{ route('account.delete') }}" class="form-stack" id="deleteAccountForm">
                @csrf
                @method('DELETE')
                <div style="margin-bottom: 1.5rem;">
                    <p style="color: var(--text-main); margin-bottom: 1rem; font-weight: 500;">
                        Are you sure you want to delete your account? This action cannot be undone.
                    </p>
                    <p style="color: var(--text-muted); font-size: 0.9rem; margin-bottom: 1rem;">
                        All your data including basket, favorites, and account information will be permanently deleted.
                    </p>
                    <p style="color: var(--error-color); font-size: 0.9rem; font-weight: 500;">
                        To confirm, please enter your password below.
                    </p>
                </div>
                <div class="form-field">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required autocomplete="current-password">
                    @error('password')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-actions" style="margin-top: 1.5rem; display: flex; gap: 0.75rem; justify-content: flex-end;">
                    <button type="button" class="btn btn-ghost" onclick="toggleDeleteAccount()">Cancel</button>
                    <button type="submit" class="btn btn-danger" id="deleteAccountButton" style="background-color: var(--error-color, #dc3545); color: white; padding: 0.5rem 1.5rem; border: none; cursor: pointer;">Delete Account</button>
                </div>
            </form>
        </div>
    </div>

    @push('styles')
        <style>
            .profile-data-section {
                display: flex;
                flex-direction: column;
                gap: 1.5rem;
            }

            .profile-data-item {
                display: flex;
                flex-direction: column;
                gap: 0.5rem;
            }

            .profile-data-label {
                font-size: 0.85rem;
                text-transform: uppercase;
                letter-spacing: 0.05em;
                color: var(--text-muted);
                font-weight: 600;
            }

            .profile-data-value {
                font-size: 1.1rem;
                color: var(--text-main);
                font-weight: 500;
                padding: 0.5rem 0;
            }

            .btn-small {
                padding: 0.5rem 1rem;
                font-size: 0.9rem;
                align-self: flex-start;
            }

            .error-message {
                color: var(--error-color, #dc3545);
                font-size: 0.875rem;
                margin-top: 0.25rem;
                display: block;
            }

            .alert-danger {
                background-color: rgba(220, 53, 69, 0.1);
                border: 1px solid rgba(220, 53, 69, 0.3);
                color: var(--error-color, #dc3545);
                padding: 1rem;
                border-radius: 0.5rem;
                margin-bottom: 1rem;
            }

            .btn-danger {
                background-color: #dc3545 !important;
                color: white !important;
                border: none;
                padding: 0.5rem 1.5rem;
                border-radius: 0.375rem;
                font-weight: 500;
                cursor: pointer;
                transition: background-color 0.2s;
            }

            .btn-danger:hover {
                background-color: #c82333 !important;
            }

            .form-actions {
                display: flex;
                gap: 0.75rem;
                justify-content: flex-end;
                margin-top: 1.5rem;
            }

            #deleteAccountButton {
                display: inline-block !important;
                visibility: visible !important;
                opacity: 1 !important;
            }
        </style>
    @endpush

    @push('scripts')
        <script>
            function toggleEditName() {
                const modal = document.getElementById('editNameModal');
                modal.classList.toggle('active');
            }

            function toggleEditEmail() {
                const modal = document.getElementById('editEmailModal');
                modal.classList.toggle('active');
            }

            function toggleEmailChangeVerification() {
                const modal = document.getElementById('emailChangeVerificationModal');
                modal.classList.toggle('active');
            }

            function toggleDeleteAccount() {
                const modal = document.getElementById('deleteAccountModal');
                modal.classList.toggle('active');
                // Reset form when closing modal
                if (!modal.classList.contains('active')) {
                    document.getElementById('deleteAccountForm').reset();
                    // Clear any error messages
                    const errorMessage = modal.querySelector('.error-message');
                    if (errorMessage) {
                        errorMessage.textContent = '';
                    }
                }
            }

            document.addEventListener('click', (event) => {
                const nameModal = document.getElementById('editNameModal');
                const emailModal = document.getElementById('editEmailModal');
                const verificationModal = document.getElementById('emailChangeVerificationModal');
                const deleteAccountModal = document.getElementById('deleteAccountModal');

                if (nameModal && nameModal.classList.contains('active') && event.target === nameModal) {
                    toggleEditName();
                }
                if (emailModal && emailModal.classList.contains('active') && event.target === emailModal) {
                    toggleEditEmail();
                }
                if (verificationModal && verificationModal.classList.contains('active') && event.target === verificationModal) {
                    toggleEmailChangeVerification();
                }
                if (deleteAccountModal && deleteAccountModal.classList.contains('active') && event.target === deleteAccountModal) {
                    toggleDeleteAccount();
                }
            });

            // Show verification modal if email was changed
            @if(session('email_change_pending'))
                document.addEventListener('DOMContentLoaded', function() {
                    toggleEmailChangeVerification();
                });
            @endif
        </script>
    @endpush
@endsection
