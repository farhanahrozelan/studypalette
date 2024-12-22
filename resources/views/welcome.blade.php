<x-guest-layout>
@section('content')
    <div class="welcome-container">
        <div class="welcome-card">
            <!-- Logo -->
            <img src="{{ asset('images/favicon.png') }}" alt="Logo" class="logo">

            <!-- Welcome Message -->
            <h1 class="text-xl font-semibold text-gray-900 mb-4">Welcome to Study Palette</h1>
            <p class="text-sm text-gray-600 mb-6">
                Your journey to seamless learning begins here. Log in or register to access your account.
            </p>

            <!-- Navigation Buttons -->
            <div class="space-y-4">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="btn-primary">
                            Go to Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="btn-primary">
                            {{ __('Log in') }}
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn-primary">
                                {{ __('Register') }}
                            </a>
                        @endif
                    @endauth
                @endif
                

            </div>
        </div>
    </div>

    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #fff7ed;
            font-family: 'Figtree', sans-serif;
        }

        .welcome-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .welcome-card {
            background-color: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
            text-align: center;
        }

        .welcome-card .logo {
            width: 80px;
            height: auto;
            margin: 0 auto 1rem; /* Center the logo and add spacing below */
        }

        .welcome-card h1,
        .welcome-card p {
            margin-bottom: 1rem;
        }

        .btn-primary {
            display: block;
            width: 100%;
            background-color: #7c3f3f;
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 5px;
            text-decoration: none;
            font-weight: 500;
            text-align: center;
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #c2837a;
        }

        .space-y-4 > *:not(:last-child) {
            margin-bottom: 1rem;
        }
    </style>
@endsection
</x-guest-layout>
