<!DOCTYPE html> 
<html lang="en"> 
    <head> 
        <meta charset="utf-8"> 
        <meta name="viewport" content="width=device-width, initial-scale=1"> 
        <title>{{ config('app.name', 'Study Palette') }}</title>

        <link rel="stylesheet" href="{{ asset('studyPalette.css') }}">

        <!-- Favicon --> 
        <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <style> 
        
        </style> 
    </head> 
    <body> 

        <div class="login-container"> 
            <div class="login-card"> 
                <!-- Logo --> 
                <img src="{{ asset('images/logo.png') }}" alt="Study Palette Logo" class="logo"> 

                <!-- Title and Subtitle --> 
                <h1>Hi, Welcome to Study Palette</h1>
                <p>Enter your details to log in to your account</p> 

                <!-- Login Form --> 
                <form action="{{ route('adminLogin') }}" method="POST"> 
                    @csrf 
                    @if (session('error')) 
                        <div class="alert"> 
                            {{ session('error') }} 
                        </div> 
                    @endif 

                    <div class="form-group"> 
                        <label for="email">Email</label> 
                        <input type="email" id="email" name="email" placeholder="Enter your email" class="form-control" required> 
                    </div> 

                    <div class="form-group"> 
                        <label for="password">Password</label> 
                        <input type="password" id="password" name="password" placeholder="Enter your password" class="form-control" required> 
                    </div> 

                    <button type="submit" class="btn-primary">Log In</button> 
                </form> 
            </div> 
        </div> 

    </body> 
</html>
