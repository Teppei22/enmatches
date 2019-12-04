@extends('layouts.app')

@section('content')
<div class="p-register">
    <div class="p-register__container">
        <div class="p-register__header l-header"><h1>{{ __('Login') }}</h1></div>
        <div class="p-register__contents">
            <div class="p-form__section">
                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="p-form__item">
                            <label for="email" class="p-form__title">{{ __('E-Mail Address') }}</label>

                            <div class="p-form__content">
                                <input id="email" type="email" class="p-form__input--text @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="p-form__item--errot" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="p-form__item">
                            <label for="password" class="p-form__title">{{ __('Password') }}</label>

                            <div class="p-form__content">
                                <input id="password" type="password" class="p-form__input--text @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="p-form__item--errot" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="p-form__item">
                            <div class="p-form__content">
                                <div class="c-checkbox">
                                    <input class="c-checkbox__input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="c-checkbox__label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="p-form__item">
                            <div class="p-form__content">
                                <button type="submit" class="c-btn c-btn--login">
                                    {{ __('Login') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
