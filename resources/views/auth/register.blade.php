@extends('layouts.app')

@section('content')
<div class="p-register">
    <div class="p-register__container">
        <div class="p-register__header"><h1>{{ __('Register') }}</h1></div>
        <div class="p-register__contents">
            <div class="p-form__section">
                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="p-form__item">
                            <label for="name" class="p-form__title">{{ __('Name') }}</label>

                            <div class="p-form__content">
                                <input id="name" type="text" class="p-form__input--text @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <div class="c-dialog--err" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="p-form__item">
                            <label for="email" class="p-form__title">{{ __('E-Mail Address') }}</label>

                            <div class="p-form__content">
                                <input id="email" type="email" class="p-form__input--text @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <div class="c-dialog--err" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="p-form__item">
                            <label for="password" class="p-form__title">{{ __('Password') }}</label>

                            <div class="p-form__content">
                                <input id="password" type="password" class="p-form__input--text @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <div class="c-dialog--err" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="p-form__item">
                            <label for="password-confirm" class="p-form__title">{{ __('Confirm Password') }}</label>

                            <div class="p-form__content">
                                <input id="password-confirm" type="password" class="p-form__input--text" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="p-form__item">
                            <div class="p-form__content offset-md-4">
                                <button type="submit" class="c-btn c-btn--login">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
