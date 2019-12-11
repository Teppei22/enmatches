<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>


    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
</head>
<body>
    <header>
        <div class="p-header">
            <div class="p-header__inner">
                <a class="p-header__title" href="{{ url('/') }}">
                    {{ config('app.name', 'Todolist') }}
                </a>
                <div class="p-header__nav">
                    <nav class="p-navHorizontal">
                        <ul class="p-navHorizontal__inner" role="menu">
                            @guest
                                <li>
                                    <a href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                                @if (Route::has('register'))
                                    <li>
                                        <a href="{{ route('register') }}">{{ __('Register') }}</a>
                                    </li>    
                                @endif
                            @else
                                <li>
                                    <a href="">{{ Auth::user()->name }}</a>
                                </li>
                                <li>
                                    <a href="{{ route('works.new') }}">new</a>
                                </li>
                                <li>
                                    <a href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                       document.getElementById('logoutForm').submit();">
                                        {{ __('Logout') }}
                                    </a>
                                    <form id="logoutForm" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </li>
                            @endguest
                            
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </header>
    <div id="app">
        @if (session('flash_message'))
            <div class="alert alert-primary text-center" role="alert">
                {{ session('flash_message') }}
            </div>
        @endif
        <main>
            @yield('content')
        </main>
    </div>
    <footer class="p-footer js-fix-footer">
        Copyright © EnMatches All Rights Reserved.
    </footer>

</body>
</html>
