@extends('layouts.app')
@section('content')
<div class="p-register l-container">
    <div class="p-register__container">
        <div class="p-register__header l-page__header"><h1>{{ __('Reset Password') }}</h1></div>
        <div class="p-register__contents">
            <div class="p-form__section">
                <div class="p-form__section__contents">
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf

                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="p-form__item">
                            <label for="email" class="p-form__title">{{ __('E-Mail Address') }}</label>

                            <div class="p-form__content">
                                <input id="email" type="email" class="p-form__input--text @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <div class="p-form__item--error" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="p-form__item">
                            <label for="password" class="p-form__title">{{ __('Password') }}</label>

                            <div class="p-form__content">
                                <input id="password" type="password" class="p-form__input--text @error('password') is-invalid @enderror" name="password" value="{{ old('password') }}" required autocomplete="new-password" autofocus>

                                @error('password')
                                    <div class="p-form__item--error" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="p-form__item">
                            <label for="password-confirm" class="p-form__title">{{ __('Confirm Password') }}</label>

                            <div class="p-form__content">
                                <input id="password-confirm" type="password" class="p-form__input--text" name="password_confirmation" value="{{ old('password-confirm') }}" required autocomplete="new-password" autofocus>

                            </div>
                        </div>

                        <div class="p-form__item">
                            <div class="p-form__content p-form__content--btn">
                                <button type="submit" class="c-btn c-btn--medium c-btn--login">
                                    {{ __('Reset Password') }}
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
