<div class="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-gray-100 selection:bg-red-500 selection:text-white" 
style="background-image: url('{{ asset('images/background.jpg') }}'); 
background-size: cover; 
background-position: center; 
background-repeat: no-repeat;">
<div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">

<div class="flex justify-center">
    <h1 class="font-semibold text-2xl text-gray-800 leading-tight text-center">
        {{ __('Welcome to Study Palette!') }}
    </h1>
</div>
<div class="flex justify-center">
    <h2 class="font-semibold text-lg text-gray-800 leading-tight text-center mt-2">
        {{ __('A Diverse Study Style Application for IIUM Students') }}
    </h2>
</div>

<div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-customColor-secondary shadow-md overflow-hidden sm:rounded-sm">
        {{ $slot }}
    </div>
    
</div>