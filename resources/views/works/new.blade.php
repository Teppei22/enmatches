@extends('layouts.app')

@section('content')
    <div class="p-register">
        <div class="p-register__container">
            <div class="p-register__header"><h1>{{ __('Work Register') }}</h1></div>
            <div class="p-register__contents">
            <div class="p-form__section">
                <div class="card-body">
                    <form method="POST" action="{{ route('works.new') }}">
                        @csrf

                        <div class="p-form__item">
                            <label for="title" class="p-form__title">{{ __('Work Title') }}</label>

                            <div class="p-form__content">
                                <input id="title" type="text" class="p-form__input--text @error('title') is-invalid @enderror" name="title" value="{{ old('title') }}" autofocus>

                                @error('title')
                                    <div class="c-dialog--err" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="p-form__item">
                            <label for="type" class="p-form__title">{{ __('Work Type') }}</label>

                            <div class="p-form__content">
                                <select name="type" class="p-form__input--select js-type_select @error('type') is-invalid @enderror" name="type" value="{{ old('type') }}" autofocus>
                                    <option value="1">個人開発</option>
                                    <option value="2">レベニューシェア</option>
                                </select>

                                @error('type')
                                    <div class="c-dialog--err" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="p-form__item">
                            <h3 class="p-form__title">{{ __('Work Price') }}</h3>
                            {{--  個人開発案件の単価  --}}
                            <div class="p-form__content js-single_price">
                                <input id="single_price_min" type="number" class="p-form__input--number @error('single_price_min') is-invalid @enderror" name="single_price_min" value="{{ old('single_price_min') }}" autofocus>
                                円 ~
                                <input id="single_price_max" type="number" class="p-form__input--number @error('single_price_max') is-invalid @enderror" name="single_price_max" value="{{ old('single_price_max') }}" autofocus>
                                円
                                @error('single_price_min')
                                    <div class="c-dialog--err" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror

                                @error('single_price_max')
                                    <div class="c-dialog--err" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>
                            {{--  レベニューシェア案件の単価  --}}
                            <div class="p-form__content js-revsh_price">
                                <input id="revenue_share_price" type="number" class="p-form__input--number @error('revenue_share_price') is-invalid @enderror" name="revenue_share_price" value="{{ old('revenue_share_price') }}" autofocus>
                                円

                                @error('revenue_share_price')
                                    <div class="c-dialog--err" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="p-form__item">
                            <label for="detail" class="p-form__title">{{ __('Work Detail') }}</label>

                            <div class="p-form__content">
                                <textarea id="detail" type="text" placeholder="お仕事の説明(1000文字以内)" class="p-form__input--text @error('detail') is-invalid @enderror" name="detail" autofocus>
                                    {{old('detail')}}
                                </textarea>
                                @error('detail')
                                    <div class="c-dialog--err" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
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