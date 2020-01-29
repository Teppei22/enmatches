@extends('layouts.app')

@section('content')
<div class="p-register l-container">
    <div class="p-register__container">
        <div class="p-register__header l-page__header"><h1>{{ __('Reset Password') }}</h1></div>
        <div class="p-register__contents">
            <div class="p-form__section">
                <div class="p-form__section__contents">
                    @if (session('status'))
                        <div class="c-dialog--success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

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
                            <div class="p-form__content p-form__content--btn">
                                <button type="submit" class="c-btn c-btn--medium c-btn--login">
                                    {{ __('Send') }}
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
