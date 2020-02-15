<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" type="image/x-icon" href="{{ asset('images/favicon/favicon.ico') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/favicon/apple-touch-icon-180x180.png') }}">

    <title>
        @hasSection ('title')
            @yield('title') | {{ config('app.name', 'Laravel') }}
        @else
            {{ config('app.name', 'Laravel') }}
        @endif
    </title>

    @hasSection ('description')
        <meta name="description" content="@yield('description')">
    @endif

    @hasSection ('keywords')
        <meta name="keywords" content="@yield('keywords')">
    @endif
    
    


    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://use.fontawesome.com/releases/v5.0.10/css/all.css" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <script>window.Promise || document.write('<script src="//www.promisejs.org/polyfills/promise-7.0.4.min.js"><\/script>');</script>
    <script>window.Promise || document.write('<script src="/js/promise-7.0.4.min.js"><\/script>');</script>
    
</head>
<body>
    <header class="p-header">
        <div class="p-header__inner">
            <a class="p-header__title" href="{{ url('/') }}">
                {{ config('app.name', 'Todolist') }}
            </a>
            <div class="c-nav__menu__triger js-toggle-sp-menu">
                <span></span>
                <span></span>
                <span></span>
            </div>
            <nav class="c-nav js-toggle-sp-menu-target">
                <ul class="c-nav__menu">
                    @guest
                        <li class="c-nav__menu__item js-toggle-sp-menu-item">
                            <a class="c-nav__menu__link" href="{{ route('register') }}">
                                <i class="fas fa-address-card"></i>
                                {{ __('Register') }}
                            </a>
                        </li>
                        <li class="c-nav__menu__item js-toggle-sp-menu-item">
                            <a class="c-nav__menu__link" href="{{ route('login') }}">
                                <i class="fas fa-address-card"></i>
                                {{ __('Login') }}
                            </a>
                        </li>
                    @else
                        <li class="c-nav__menu__item js-toggle-sp-menu-item">
                            <a class="c-nav__menu__link" href="{{ route('mypage') }}">
                                <i class="fas fa-tachometer-alt"></i>
                                {{ __('Mypage') }}
                            </a>
                        </li>
                        <li class="c-nav__menu__item js-toggle-sp-menu-item">
                            <a class="c-nav__menu__link" href="{{ route('message') }}">
                                <i class="fas fa-envelope"></i>
                            {{ __('Message') }}
                            </a>
                        </li>
                        <li class="c-nav__menu__item js-toggle-sp-menu-item">
                            <a class="c-nav__menu__link" href="{{ route('works.index') }}">
                                <i class="fas fa-briefcase"></i>
                                {{ __('Search Work') }}
                            </a>
                        </li>
                        <li class="c-nav__menu__item js-toggle-sp-menu-item">
                            <a class="c-nav__menu__link" href="{{ route('works.create') }}">
                                <i class="fas fa-file-alt"></i>
                                {{ __('Register Work') }}
                            </a>
                        </li>
                        
                        <li class="c-nav__menu__item js-toggle-sp-menu-item">
                            <a class="c-nav__menu__link" href="{{ route('profile') }}">
                                <i class="fas fa-address-card"></i>
                                {{ __('Edit Profile') }}
                            </a>
                        </li>
                        <li class="c-nav__menu__item js-toggle-sp-menu-item">
                            <a class="c-nav__menu__link" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                document.getElementById('logoutForm').submit();">
                                {{ __('Logout') }}
                            </a>
                        </li>
                    @endguest
                </ul>
                
            </nav>
            <div class="p-header__nav">
                <nav class="p-nav--horizontal">
                    <ul class="p-nav--horizontal__inner" role="menu">
                        @guest
                            <li>
                                <a href="{{ route('works.index') }}">{{ __('Search Work') }}</a>
                            </li>
                            <li>
                                <a href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            <li>
                                <a href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
                        @else
                            <li>
                                <a href="{{ route('mypage') }}">{{ __('Mypage') }}</a>
                            </li>
                            <li>
                                <a href="{{ route('works.index') }}">{{ __('Search Work') }}</a>
                            </li>
                            <li>
                                <a href="{{ route('works.create') }}">{{ __('Work Register') }}</a>
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
    </header>
    <main id="app" class="wrapper">

        @if (session('flash_message'))
            <div class="c-flash-message js-flash-message" role="alert">
                <div class="c-flash-message__text">
                    {{ session('flash_message') }}
                </div>
            </div>
        @endif

        @yield('side_content')
        @yield('content')
    </main>
    <footer class="p-footer js-fix-footer">
        Copyright © EnMatches All Rights Reserved.
    </footer>

</body>
</html>
