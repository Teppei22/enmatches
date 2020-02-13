@extends('layouts.app')

@section('description',config('app.name', 'Laravel').'はネットでお手軽にお仕事を発注・受注できるWEBサービスです。ホームページやハードウェア・アプリ制作からバナーやロゴのデザインまで専門性の高い案件を発注できます。今すぐ無料で会員登録してお仕事を発注しましょう')

@section('keywords',config('app.name', 'Laravel').', HP 発注, デザイン 発注, システム開発 発注')

@section('content')
<div class="p-register">
    <div class="p-register__container l-container">
        <div class="p-register__header l-container__header"><h1>{{ __('Member Register') }}</h1></div>
        <div class="p-register__contents">
            <div class="p-form__section">
                <div class="p-form__section__contents">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="p-form__item">
                            <label for="name" class="p-form__title">{{ __('Name') }}</label>

                            <div class="p-form__content">
                                <input id="name" type="text" class="p-form__input--text @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}"  autocomplete="name" autofocus>

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
                                <input id="email" type="email" class="p-form__input--text @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}"  autocomplete="email">

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
                                <input id="password" type="password" class="p-form__input--text @error('password') is-invalid @enderror" name="password"  autocomplete="new-password">

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
                                <input id="password-confirm" type="password" class="p-form__input--text" name="password_confirmation"  autocomplete="new-password">
                            </div>
                        </div>

                        <div class="p-form__item">
                            <div class="p-form__content p-form__content--btn">
                                <button type="submit" class="c-btn c-btn--medium c-btn--login">
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
