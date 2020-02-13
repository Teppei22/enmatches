<div class="p-register l-container">
    <div class="p-register__container">
        <div class="p-register__header l-container__header"><h1>{{ $page_title }}</h1></div>
        <div class="p-register__contents">
        <div class="p-form__section">
            <div class="p-form__section__contents">
                <form method="POST" action="{{ $post_action }}">
                    @csrf
                    <div class="p-form__item">
                        <label for="title" class="p-form__title">{{ __('Work Title') }}</label>

                        <div class="p-form__content">
                            <input id="title" type="text" class="p-form__input--text @error('title') is-invalid @enderror" name="title" value="{{ old('title', $title_default) }}" autofocus>

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
                            <select name="type_id" class="p-form__input--select js-type_select @error('type_id') is-invalid @enderror" autofocus>
                                @foreach ($work_types as $key => $val)
                                    <option value="{{ $val["id"] }}" @if((int)old('type_id', $type_id_default) === $val["id"])selected @endif>{{ $val["name"] }}</option>
                                @endforeach
                            </select>

                            @error('type_id')
                                <div class="c-dialog--err" role="alert">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="p-form__item js-work_price">
                        <h3 class="p-form__title">{{ __('Work Price') }}</h3>
                        {{--  単発案件の単価  --}}
                        <div class="p-form__content">
                            <input id="single_price_min" type="number" class="p-form__input--number js-price-min @error('single_price_min') is-invalid @enderror" name="single_price_min" value="{{ old('single_price_min', $single_price_min_default) }}" step=1000 autofocus>
                            円以上 ~
                            <input id="single_price_max" type="number" class="p-form__input--number js-price-max @error('single_price_max') is-invalid @enderror" name="single_price_max" value="{{ old('single_price_max', $single_price_max_default) }}" step=1000 autofocus>
                            円以下
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
                    </div>

                    <div class="p-form__item">
                        <label for="detail" class="p-form__title">{{ __('Work Detail') }}</label>

                        <div class="p-form__content">
                            <textarea id="detail" type="text" placeholder="お仕事の説明(1000文字以内)" class="p-form__input--textarea @error('detail') is-invalid @enderror" name="detail" autofocus>{{old('detail', $detail_default)}}</textarea>
                            @error('detail')
                                <div class="c-dialog--err" role="alert">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>
                    </div>


                    <div class="p-form__item">
                        <div class="p-form__content p-form__content--btn">
                            <button type="submit" class="c-btn c-btn--medium c-btn--login">
                                {{ $submit_word }}
                            </button>
                        </div>
                    </div>

                    @if (!empty($delete_flg))
                        <div class="p-form__item">
                            <div class="p-form__content p-form__content--btn">
                                <button formaction="{{ $delete_action }}" type="submit" class="c-btn c-btn--medium c-btn--destroy" onclick='return confirm("この案件を削除しますか？");'>
                                    {{ __('Delete') }}
                                </button>
                            </div>
                        </div>
                    @endif
                    

                </form>
            </div>
        </div>
    </div>
    </div>
</div>