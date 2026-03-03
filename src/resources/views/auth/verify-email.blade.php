@extends('layouts.app')

@section('title', 'Verify Email — Klavera')

@section('content')
    <div class="auth-shell">
        <div class="auth-card">
            <div class="auth-heading">
                <p class="overline">Email Verification</p>
                <h1>Verify Your Email</h1>
                <p style="color: var(--text-muted); font-size: 0.95rem;">
                    Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you?
                </p>
            </div>

            @if (session('status') == 'verification-link-sent')
                <div class="alert alert-success" style="margin-bottom: 1.5rem;">
                    A new verification link has been sent to the email address you provided during registration.
                </div>
            @endif

            @if (session('message'))
                <div class="alert alert-success" style="margin-bottom: 1.5rem;">
                    {{ session('message') }}
                </div>
            @endif

            <div class="form-stack">
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <button type="submit" class="btn btn-primary btn-full">
                        Resend Verification Email
                    </button>
                </form>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-secondary btn-full" style="margin-top: 1rem;">
                        Log Out
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
