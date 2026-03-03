@extends('layouts.app')

@section('title', 'Change Password — Klavera')

@section('content')
    <div class="auth-shell">
        <div class="auth-card">
            <div class="auth-heading">
                <p class="overline">Security</p>
                <h1>Update Password</h1>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul style="margin: 0; padding-left: 1.2rem;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('changePassword') }}" class="form-stack">
                @csrf
                <div class="form-field">
                    <label for="current_password">Current Password</label>
                    <input type="password" id="current_password" name="current_password" required>
                </div>
                <div class="form-field">
                    <label for="new_password">New Password</label>
                    <input type="password" id="new_password" name="new_password" required>
                </div>
                <div class="form-field">
                    <label for="new_password_confirmation">Confirm Password</label>
                    <input type="password" id="new_password_confirmation" name="new_password_confirmation" required>
                </div>
                <button type="submit" class="btn btn-primary btn-full">Save</button>
            </form>
        </div>
    </div>
@endsection
