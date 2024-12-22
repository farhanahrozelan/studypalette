<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
     <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1">
     <meta name="csrf-token" content="{{ csrf_token() }}">
     <title>{{ config('app.name', 'Study Palette') }}</title>
     <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">
     <link rel="stylesheet" href="{{ asset('css/admin.css') }}">

     <!-- PWA -->
     <link rel="manifest" href="{{ asset('manifest.json') }}">      

     <!-- Toastr CSS -->
     <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">

     <!-- jQuery (required for Toastr) -->
     <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

     <!-- Toastr JS -->
     <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

     <!-- Favicon --> 
     <link rel="icon" type="image/png" href="{{ url('favicon.png') }}">

<!-- Fonts -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="preconnect" href="https://fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600&display=swap" rel="stylesheet">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Dancing+Script&family=Satisfy&display=swap" rel="stylesheet">

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/luxon"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-luxon"></script>

     <!-- Include External CSS -->
     <link rel="stylesheet" href="styles.css">

     @vite(['resources/css/app.css', 'resources/js/app.js'])
     @livewireStyles

     
    <style>
        body {  
            margin: 0;  
            padding: 0;   
            background-color: #fff7ed;  
            font-family: 'Figtree', sans-serif;  
        }  

        header { 
            background-color: #c2837a;  
            color: #7c3f3f;  
            padding: 10px;  
            font-size: 1.5rem;  
            font-weight: bold;  
            font-family: 'Satisfy', cursive;  
            text-shadow: 0.5px 0.5px 0.5px rgba(0, 0, 0, 0.2);  
            position: fixed;  
            top: 0;  
            width: 100%;  
            z-index: 1000;  
            box-shadow: 0 4px 2px -2px rgba(0, 0, 0, 0.1);  
            display: flex; /* Use flexbox for layout */ 
            align-items: center; /* Align items vertically */ 
            justify-content: center; /* Center the content horizontally */ 
        } 

        header img.logo { 
            height: 2rem; /* Match the header font size */ 
            margin-right: 10px; /* Add space between logo and text */ 
        } 

        header .logout-button { 
            position: absolute; 
            right: 20px; /* Adjust the distance from the right edge */ 
            color: #7c3f3f; 
            font-size: 1.2rem; 
            text-decoration: none; 
            background: none; 
            border: none; 
            cursor: pointer; 
            display: flex; 
            align-items: center; 
            gap: 5px; 
        }

        header .logout-button:hover { 
            color: #9a5656; 
        }

        header .logout-button i { 
            font-size: 1.5rem; /* Icon size */ 
        }

        .main-content { 
         margin-left: 70px; 
         padding: 10px; 
         flex: 1; 
         background-color: #f3f4f6; 
         transition: margin-left 0.3s ease; 
}
    </style>
</head>
<body>
    <header> 
        <img src="{{ asset('images/logo.png') }}" class="logo" alt="Logo"> 
        <span>Study Palette</span>
        <a href="{{ route('welcome') }}" class="logout-button">
            <i class="fas fa-sign-out-alt"></i>
        </a>
    </header>

    <div class="min-h-screen bg-gray-100">
        <!-- Page Content -->
        <main>
            <div class="main-content" id="main-content">
                @yield('content')
            </div>
        </main>
    </div>

    @stack('modals')
    @livewireScripts

    <script>
        if ("serviceWorker" in navigator) {
            navigator.serviceWorker.register('/sw.js', { scope: '/' })
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
