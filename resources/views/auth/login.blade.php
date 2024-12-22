<x-guest-layout>
@section('content')
    <div class="login-container">
        <div class="login-card">
            <!-- Logo -->
            <img src="{{ asset('images/favicon.png') }}" alt="Logo" class="logo">

            <!-- Welcome Message -->
            <h1 class="text-xl font-semibold text-gray-900 mb-4">Hi, Welcome to Study Palette</h1>
            <p class="text-sm text-gray-600 mb-4">Enter your details to log in to your account</p>

            <!-- Session Status -->
            @if (session('status'))
                <div class="alert alert-danger mb-4">
                    {{ session('status') }}
                </div>
            @endif

            <!-- Validation Errors -->
            <x-validation-errors class="mb-4" />

            <!-- Login Form -->
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email Address -->
                <div class="mb-4">
                    <x-label for="email" value="{{ __('Email') }}" />
                    <x-input id="email" class="form-control" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                </div>

                <!-- Password -->
                <div class="mb-4 relative">
                    <x-label for="password" value="{{ __('Password') }}" />
                    <div class="password-wrapper">
                        <x-input id="password" class="form-control" type="password" name="password" required autocomplete="current-password" />
                        
                        <!-- Toggle Show/Hide Password Icon -->
                        <button type="button" id="toggle-password" class="password-toggle">
                            <i class="fa fa-eye-slash" id="eye-icon"></i>
                        </button>
                    </div>
                </div>

                <!-- Remember Me -->
                <div class="block mb-4">
                    <label for="remember_me" class="flex items-center">
                        <x-checkbox id="remember_me" name="remember" />
                        <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                    </label>
                </div>

                <!-- Links -->
                <div class="flex flex-col space-y-2 mb-4">
                    @if (Route::has('password.request'))
                        <a class="text-sm text-gray-600 hover:text-gray-800 hover:underline" href="{{ route('password.request') }}">
                            {{ __('Forgot your password?') }}
                        </a> 
                    @endif
                    <a class="text-sm text-gray-600 hover:text-gray-800 hover:underline" href="{{ route('register') }}">
                        {{ __('New user? Create an account') }}
                    </a>
                </div>

                <!-- Login Button -->
                <div class="flex items-center justify-end">
                    <x-button class="btn-primary">
                        {{ __('Log in') }}
                    </x-button>
                </div>
            </form>
        </div>
    </div>

    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #fff7ed;
            font-family: 'Figtree', sans-serif;
        }

        .login-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .login-card {
            background-color: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
        }

        .login-card h1,
        .login-card p {
            text-align: center;
            margin-bottom: 1rem;
        }

        .login-card .logo {
            width: 80px;
            height: auto;
            margin: 0 auto 1rem;
        }

        .login-card .form-control {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-top: 0.5rem;
        }

        .password-wrapper {
            position: relative;
        }

        .password-wrapper .form-control {
            padding-right: 2.5rem; /* Reserve space for the eye icon */
        }

        .password-toggle {
            background: none;
            border: none;
            position: absolute;
            top: 55%;
            right: 10px;
            transform: translateY(-50%);
            font-size: 0.8rem;
            cursor: pointer;
            color: rgb(150, 150, 150);
        }

        .login-card .alert {
            padding: 0.75rem;
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
            border-radius: 5px;
        }

        .btn-primary {
            display: inline-block;
            background-color: #7c3f3f;
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 5px;
            text-align: center;
            text-decoration: none;
            font-weight: 500;
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #c2837a;
        }
    </style>

    <script>
        // Toggle password visibility on icon click
        document.getElementById('toggle-password').addEventListener('click', function () {
            const passwordField = document.getElementById('password');
            const eyeIcon = document.getElementById('eye-icon');

            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
            } else {
                passwordField.type = 'password';
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash');
            }
        });
    </script>
@endsection
</x-guest-layout>
