@extends('admin.layout')
@section('title', 'My Account')
@section('subtitle', 'Update your login email and password.')

@section('content')
<form method="POST" action="{{ route('admin.account.update') }}" class="card narrow stack">
    @csrf @method('PUT')
    <div class="row-2">
        <label class="f"><span>Name</span><input type="text" name="name" value="{{ old('name', $user->name) }}" required></label>
        <label class="f"><span>Email</span><input type="email" name="email" value="{{ old('email', $user->email) }}" required></label>
    </div>
    <hr>
    <p class="muted">Leave the password fields empty to keep your current password.</p>
    <label class="f"><span>Current password</span><input type="password" name="current_password" autocomplete="current-password"></label>
    <div class="row-2">
        <label class="f"><span>New password</span><input type="password" name="password" autocomplete="new-password"></label>
        <label class="f"><span>Confirm new password</span><input type="password" name="password_confirmation" autocomplete="new-password"></label>
    </div>
    <button class="b b--primary"><i class="bi bi-check2"></i> Save</button>
</form>
@endsection
