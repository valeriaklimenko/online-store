@extends('layouts.app')

@section('title', 'Profile — ' . $user->name)

@section('content')
    @if(session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    <section class="profile-grid">
        <article class="card profile-card">
            <p class="overline">Klavera Team</p>
            <span class="badge" style="margin-bottom: 1rem;">Manager</span>
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
            </div>
        </article>

        <article class="card profile-menu-card">
            <h2>Control Panel</h2>
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
                    <a href="{{ route('products.index') }}">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                        <span>Product Management</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                        <span>Business Analytics</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                        </svg>
                        <span>Store Orders</span>
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

            document.addEventListener('click', (event) => {
                const nameModal = document.getElementById('editNameModal');
                const emailModal = document.getElementById('editEmailModal');
                const verificationModal = document.getElementById('emailChangeVerificationModal');

                if (nameModal && nameModal.classList.contains('active') && event.target === nameModal) {
                    toggleEditName();
                }
                if (emailModal && emailModal.classList.contains('active') && event.target === emailModal) {
                    toggleEditEmail();
                }
                if (verificationModal && verificationModal.classList.contains('active') && event.target === verificationModal) {
                    toggleEmailChangeVerification();
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










