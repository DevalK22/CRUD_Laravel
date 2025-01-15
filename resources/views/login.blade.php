<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    @include('layouts.success_alert')
</head>
<body class="bg-light">
    <div class="container vh-100 d-flex justify-content-center align-items-center">
        <div class="card p-4 shadow-sm" style="width: 22rem;">
            <h3 class="text-center mb-4">Login</h3>
            <form method="POST" action="{{ route('employee.logged.in') }}">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" autocomplete="off">
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <input type="checkbox" name="remember" id="remember">
                        <label for="remember" class="form-check-label">Remember Me</label>
                    </div>
                    <a href="#" class="small">Forgot Password?</a>
                </div>
                <button type="submit" class="btn btn-primary w-100">Login</button>
            </form>
            <div class="text-center mt-4">
                <a href="{{route('admin.login.page')}}" class="btn btn-secondary w-100">Admin Login</a>
            </div>
            <div class="text-center mt-3">
                <small>Don't have an account? <a href="{{ route('employee.register') }}">Register</a></small>
            </div>
        </div>
    </div>
</body>
</html>
