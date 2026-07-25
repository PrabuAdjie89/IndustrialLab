<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Forgot Password</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

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

        .register-link {
            color: white;
            font-weight: 600;
            text-decoration: none;
        }

        .register-link:hover {
            color: #d1d5db;
            text-decoration: underline;
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
                            Forgot Password
                        </h2>

                        <p class="text-white-50 mb-5">
                            Masukkan email Anda untuk menerima link reset password
                        </p>

                    </div>



                    @if (session('status'))

                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>

                    @endif



                    <form method="POST" action="{{ route('password.email') }}">

                        @csrf



                        {{-- Email --}}

                        <div class="mb-4 text-start">

                            <label for="email" class="form-label">
                                Email
                            </label>


                            <input
                                id="email"
                                type="email"
                                name="email"
                                value="{{ old('email') }}"
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



                        <button
                            type="submit"
                            class="btn btn-outline-light btn-lg w-100">

                            Kirim Link Reset Password

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
</body>
</html>