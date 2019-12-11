@extends('layouts.app')

@section('content')
<div class="p-register">
    <div class="p-register__container">
        <div class="p-register__header l-header"><h1>{{ __('Edit Profile') }}</h1></div>
        <div class="p-register__contents">
            <div class="p-form__section">
                <div class="card-body">
                    <form method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="p-form__item">
                            

                            <div class="p-form__content">
                                <label for="thumbnail" class="p-form__content--img js-area-drop @error('thumbnail') is-invalid @enderror">
                                    <input type="hidden" name="MAX_FILE_SIZE" value="3145728">
                                    <input type="file" name="thumbnail" class="p-form__input--file js-input-file">
                                    <img class="p-form__input--prev-img js-prev-img" src="@if($is_image){{ asset("storage/profile_thumbnail/".Auth::id().".jpg") }}@endif">
                                        
                                </label>
                                
                                @error('thumbnail')
                                    <div class="c-dialog--err" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>
                            
                        </div>
                        

                        <div class="p-form__item">
                            <label for="name" class="p-form__title"></label>

                            <div class="p-form__content">
                                <input id="name" type="text" class="p-form__input--text @error('name') is-invalid @enderror" name="name" value="{{ old('name',$user->name) }}" autocomplete="name" autofocus>

                                @error('name')
                                    <div class="c-dialog--err" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="p-form__item">
                            <label for="description" class="p-form__title"></label>

                            <div class="p-form__content">
                                <textarea id="description" type="text" 
                                placeholder="こんにちは。ご覧頂きありがとうございます。&#13;&#10;私のスキルは・・・" class="p-form__input--textarea @error('description') is-invalid @enderror" name="description" autofocus>
                                    {{old('description')}}
                                </textarea>
                                @error('description')
                                    <div class="c-dialog--err" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>
                        </div>


                        <div class="p-form__item">
                            <div class="p-form__content">
                                <button type="submit" class="c-btn c-btn--login">
                                    {{ __('Change') }}
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
