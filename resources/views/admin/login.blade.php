<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <title>Admin Login · ANP Nursing Home</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/img/misc/favicon.png') }}">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('assets/admin/admin.css') }}?v=1">
</head>
<body class="login">
    <div class="login__art">
        <img src="{{ asset('assets/img/misc/hospital-building.webp') }}" alt="">
        <div class="login__quote">
            <img src="{{ asset('assets/img/misc/logo-mark.webp') }}" alt="" width="64" height="64">
            <h2>ANP Nursing Home</h2>
            <p>Multi Speciality Hospital · Coimbatore</p>
            <p class="login__tamil">(ANP) அனைவரும் நலம்பெற</p>
        </div>
    </div>
    <div class="login__panel">
        <form method="POST" action="{{ route('admin.login.submit') }}" class="login__form">
            @csrf
            <h1>Welcome back</h1>
            <p class="muted">Sign in to manage the website, departments and enquiries.</p>

            @if (session('ok'))<div class="adm-alert adm-alert--ok">{{ session('ok') }}</div>@endif
            @error('email')<div class="adm-alert adm-alert--err"><i class="bi bi-exclamation-triangle-fill"></i> {{ $message }}</div>@enderror

            <label class="f">
                <span>Email</span>
                <div class="f__icon"><i class="bi bi-envelope"></i><input type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"></div>
            </label>
            <label class="f">
                <span>Password</span>
                <div class="f__icon"><i class="bi bi-lock"></i><input type="password" name="password" required autocomplete="current-password"></div>
            </label>
            <label class="check"><input type="checkbox" name="remember" value="1"> Keep me signed in</label>
            <button class="b b--primary b--block b--lg" type="submit"><i class="bi bi-box-arrow-in-right"></i> Sign in</button>
            <a href="{{ route('home') }}" class="login__back"><i class="bi bi-arrow-left"></i> Back to website</a>
        </form>
    </div>
</body>
</html>
