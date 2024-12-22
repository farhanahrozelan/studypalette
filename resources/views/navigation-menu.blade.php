<nav x-data="{ open: false }" class="bg-customColor-primary w-full fixed top-0 z-[1000]">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600&display=swap" rel="stylesheet">

    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
            <!-- Left Section: Spacer (optional, can be empty if no left content) -->
            <div class="flex items-center"></div>

            <!-- Center Section: Logo -->
            <div class="absolute left-1/2 transform -translate-x-1/2">
                <a href="{{ route('dashboard') }}" class="flex items-center space-x-2">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-12 w-auto" />
                    <h1 style="font-family: 'Satisfy', cursive; color: #7c3f3f; font-weight: bold; font-size: 1.5rem; text-shadow: 0.5px 0.5px 0.5px rgba(0, 0, 0, 0.2);"
                    >Study Palette</h1>
                    </a>
            </div>

            <!-- Right Section: Profile Icon and Dropdown -->
            <div class="flex items-center space-x-4">

                <!-- Settings Dropdown -->
                <div class="ms-3 relative">
                    <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                                <!-- Replace Username with Icon -->
                                <button class="flex items-center text-white focus:outline-none">
                                    <i class="fas fa-user-circle text-2xl"></i>
                                </button>
                            </x-slot>



                        <x-slot name="content">
                            <!-- Profile -->
                            <x-dropdown-link href="{{ route('profile.show') }}">
                                <i class="fas fa-user me-2"></i> Profile
                            </x-dropdown-link>

                            <!-- API Tokens -->
                            @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                                <x-dropdown-link href="{{ route('api-tokens.index') }}">
                                    <i class="fas fa-key me-2"></i> API Tokens
                                </x-dropdown-link>
                            @endif

                            <div class="border-t border-gray-200"></div>

                            <!-- Log Out -->
                            <form method="POST" action="{{ route('logout') }}" x-data>
                                @csrf
                                <x-dropdown-link href="{{ route('logout') }}" @click.prevent="$root.submit();">
                                    <i class="fas fa-sign-out-alt me-2"></i> Log Out
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                Dashboard
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="flex items-center px-4">
                <div>
                    <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <!-- Account Management -->
                <x-responsive-nav-link href="{{ route('profile.show') }}" :active="request()->routeIs('profile.show')">
                    Profile
                </x-responsive-nav-link>

                @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                    <x-responsive-nav-link href="{{ route('api-tokens.index') }}" :active="request()->routeIs('api-tokens.index')">
                        API Tokens
                    </x-responsive-nav-link>
                @endif

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}" x-data>
                    @csrf
                    <x-responsive-nav-link href="{{ route('logout') }}" @click.prevent="$root.submit();">
                        Log Out
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
