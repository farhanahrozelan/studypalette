<x-guest-layout>
@section('content')
    <div class="register-container">
        <div class="register-card">
            <!-- Logo -->
            <img src="{{ asset('images/favicon.png') }}" alt="Logo" class="logo">

            <!-- Welcome Message -->
            <h1 class="text-xl font-semibold text-gray-900 mb-4">Create Your Account</h1>
            <p class="text-sm text-gray-600 mb-4">Please fill in the details to sign up</p>

            <!-- Validation Errors -->
            <x-validation-errors class="mb-4" />

            <!-- Registration Form -->
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Name -->
                <div class="mb-4">
                    <x-label for="name" value="{{ __('Name') }}" />
                    <x-input id="name" class="form-control" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                </div>

                <!-- Email -->
                <div class="mb-4">
                    <x-label for="email" value="{{ __('Email') }}" />
                    <x-input id="email" class="form-control" type="email" name="email" :value="old('email')" required autocomplete="username" />
                </div>

                <!-- Password -->
                <div class="mb-4">
                    <x-label for="password" value="{{ __('Password') }}" />
                    <x-input id="password" class="form-control" type="password" name="password" required autocomplete="new-password" />
                </div>

                <!-- Confirm Password -->
                <div class="mb-4">
                    <x-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                    <x-input id="password_confirmation" class="form-control" type="password" name="password_confirmation" required autocomplete="new-password" />
                </div>

                <!-- Terms and Conditions -->
                @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                    <div class="mb-4">
                        <x-label for="terms">
                            <div class="flex items-center">
                                <x-checkbox name="terms" id="terms" required />
                                <div class="ml-2 text-sm text-gray-600">
                                    {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                        'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="text-gray-600 hover:text-gray-800 hover:underline">'.__('Terms of Service').'</a>',
                                        'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="text-gray-600 hover:text-gray-800 hover:underline">'.__('Privacy Policy').'</a>',
                                    ]) !!}
                                </div>
                            </div>
                        </x-label>
                    </div>
                @endif

                <!-- Register Button -->
                <div class="flex items-center justify-between">
                    <a class="text-sm text-gray-600 hover:text-gray-800 hover:underline" href="{{ route('login') }}">
                        {{ __('Already registered?') }}
                    </a>

                    <x-button class="btn-primary">
                        {{ __('Register') }}
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

        .register-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .register-card {
            background-color: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
        }

        .register-card h1,
        .register-card p {
            text-align: center;
            margin-bottom: 1rem;
        }

        .register-card .logo {
            width: 80px;
            height: auto;
            margin: 0 auto 1rem;
        }

        .register-card .form-control {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-top: 0.5rem;
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
@endsection
</x-guest-layout>
