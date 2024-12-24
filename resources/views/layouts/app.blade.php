<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
     <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1">
     <meta name="csrf-token" content="{{ csrf_token() }}">
     <title>{{ config('app.name', 'Study Palette') }}</title>
     <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">

     <!-- PWA -->
     <link rel="manifest" href="{{ asset('manifest.json') }}">      

     <!-- Toastr CSS --> 
     <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">

     <!-- jQuery (required for Toastr) -->
     <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

     <!-- Toastr JS -->
     <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

     <!-- Fonts -->
      <link href="https://fonts.googleapis.com/css2?family=Satisfy&display=swap" rel="stylesheet">
      <link rel="preconnect" href="https://fonts.bunny.net">
      <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
      <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" 
          integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" 
          crossorigin="anonymous" referrerpolicy="no-referrer">
    
     <!-- Include External CSS -->
     <link rel="stylesheet" href="styles.css">

     @vite(['resources/css/app.css', 'resources/js/app.js'])
     @livewireStyles
    </head>
    <body class="font-sans antialiased">
       <x-banner />

        <div class="min-h-screen bg-gray-100">
        <!-- Sidebar -->
         <div class="sidebar collapsed" id="sidebar">

            <ul>
                
            <button class="toggle-btn" id="toggle-btn">
                <i class="fa-solid fa-bars"></i>
            </button>

                <li>
                    <a href="{{ route('dashboard') }}" class="menu-item">
                        <i class="fas fa-home"></i>
                        <span>Home</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('notes.index') }}" class="menu-item">
                        <i class="fa-regular fa-note-sticky"></i>
                        <span>Notes</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('flashcards.index') }}" class="menu-item">
                        <i class="fa-solid fa-copy"></i>
                        <span>Flashcards</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('tasks.index') }}" class="menu-item">
                        <i class="fa-solid fa-list-check"></i>
                        <span>Tasks</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('notes.shared') }}" class="menu-item">
                        <i class="fa-brands fa-creative-commons-share"></i>
                        <span>Shared Notes</span>
                    </a>
                </li>
            </ul>
        </div>

        <!-- Navigation Menu -->
        @livewire('navigation-menu')

        <!-- Page Content -->
        <main>
            <div class="main-content" id="main-content">
                @yield('content')
            </div>
        </main>
    </div>

    @stack('modals')
    @livewireScripts

    <!-- Sidebar Toggle Script -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const toggleBtn = document.getElementById('toggle-btn');
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('main-content');

            toggleBtn.addEventListener('click', () => {
                sidebar.classList.toggle('collapsed');
                mainContent.classList.toggle('collapsed');
            });
        });
    </script>

<script>
    if ("serviceWorker" in navigator) {
        navigator.serviceWorker.register('/sw.js', { scope: '/' });// Updated path to match your file name
            .then((registration) => {
                console.log("Service Worker registered with scope:", registration.scope);
            })
            .catch((error) => {
                console.error("Service Worker registration failed:", error);
            });
    }
</script>


<script>
    @if(session('success'))
        toastr.success("{{ session('success') }}", "Success", {
            closeButton: true,
            progressBar: true,
            positionClass: 'toast-top-right',
            timeOut: 3000,
        });
    @elseif(session('error'))
        toastr.error("{{ session('error') }}", "Error", {
            closeButton: true,
            progressBar: true,
            positionClass: 'toast-top-right',
            timeOut: 3000,
        });
    @endif
</script>

</body>
</html>
