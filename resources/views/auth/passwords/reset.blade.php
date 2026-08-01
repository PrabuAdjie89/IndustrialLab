<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Reset Password</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        html,
        body {
            height: 100%;
            margin: 0;
            padding: 0;
        }

        body {
            min-height: 100vh;
            background: linear-gradient(
                135deg,
                #6a11cb 0%,
                #2575fc 100%
            );
        }

        .login-wrapper {
            min-height: 100vh;
        }

        .login-card {
            background: rgba(33, 37, 41, 0.95);
            border-radius: 1rem;
            color: white;
            border: none;
        }

        .form-control {
            min-height: 50px;
        }

        .input-group .form-control {
            min-height: 50px;
        }

        .register-link {
            color: white;
            font-weight: 600;
            text-decoration: none;
        }

        .register-link:hover {
            color: #d1d5db;
            text-decoration: underline;
        }

        .input-group .btn {
            border-color: #ced4da;
        }

        .input-group .btn i {
            font-size: 1.1rem;
        }
    </style>
</head>

<body>

<div class="container login-wrapper">
    <div class="row justify-content-center align-items-center min-vh-100">

        <div class="col-12 col-md-8 col-lg-6 col-xl-5">

            <div class="card login-card shadow-lg">

                <div class="card-body p-5">

                    <div class="text-center">

                        <h2 class="fw-bold mb-2 text-uppercase">
                            Reset Password
                        </h2>

                        <p class="text-white-50 mb-5">
                            Buat password baru untuk akun Anda
                        </p>

                    </div>


                    @if(session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif


                    <form method="POST" action="{{ route('password.update') }}">

                        @csrf

                        <input type="hidden" name="token" value="{{ $token }}">


                        {{-- Email --}}
                        <div class="mb-4 text-start">

                            <label for="email" class="form-label">
                                Email
                            </label>

                            <input
                                id="email"
                                type="email"
                                name="email"
                                value="{{ $email ?? old('email') }}"
                                class="form-control @error('email') is-invalid @enderror"
                                required
                                autofocus
                                autocomplete="email">


                            @error('email')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>



                        {{-- Password Baru --}}
                        <div class="mb-4 text-start">

                            <label for="password" class="form-label">
                                Password Baru
                            </label>


                            <div class="input-group">

                                <input
                                    id="password"
                                    type="password"
                                    name="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    required
                                    autocomplete="new-password">


                                <button
                                    class="btn btn-light"
                                    type="button"
                                    id="togglePassword">

                                    <i class="bi bi-eye"></i>

                                </button>

                            </div>
                            @error('password')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>
                        {{-- Konfirmasi Password --}}
                        <div class="mb-4 text-start">
                            <label for="password-confirm" class="form-label">
                                Konfirmasi Password
                            </label>
                            <div class="input-group">
                                <input
                                    id="password-confirm"
                                    type="password"
                                    name="password_confirmation"
                                    class="form-control"
                                    required
                                    autocomplete="new-password">
                                <button
                                    class="btn btn-light"
                                    type="button"
                                    id="toggleConfirmPassword">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                        </div>
                        <button
                            type="submit"
                            class="btn btn-outline-light btn-lg w-100">
                            Reset Password
                        </button>
                    </form>
                    <div class="text-center mt-4">

                        <a href="{{ route('login') }}"
                           class="text-white-50 text-decoration-none">
                            Kembali ke Login
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>

    document.getElementById('togglePassword').addEventListener('click', function () {

        const password = document.getElementById('password');
        const icon = this.querySelector('i');


        if(password.type === 'password') {

            password.type = 'text';
            icon.classList.remove('bi-eye');
            icon.classList.add('bi-eye-slash');

        } else {

            password.type = 'password';
            icon.classList.remove('bi-eye-slash');
            icon.classList.add('bi-eye');

        }

    });



    document.getElementById('toggleConfirmPassword').addEventListener('click', function () {

        const password = document.getElementById('password-confirm');
        const icon = this.querySelector('i');


        if(password.type === 'password') {

            password.type = 'text';
            icon.classList.remove('bi-eye');
            icon.classList.add('bi-eye-slash');

        } else {

            password.type = 'password';
            icon.classList.remove('bi-eye-slash');
            icon.classList.add('bi-eye');

        }

    });
</script>
</body>
</html>