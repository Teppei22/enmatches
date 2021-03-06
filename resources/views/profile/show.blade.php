@extends('layouts.app')

@section('title',$user->name.'さんのプロフィール')

@section('content')
<div class="p-register">
    <div class="p-register__container l-container">
        <div class="p-register__header l-container__header"><h1>{{ $user->name }}{{ __("'s ") }}<br>{{ __('Profile') }}</h1></div>
        <div class="p-register__contents">
            <div class="p-form__section">
                <div class="p-form__section__contents">

                  <div class="p-form__item">

                    <div class="p-form__content">

                        <label for="thumbnail" class="p-form__content--img">
                        <img class="p-form__input--prev-img" 
                        src="@if(!empty($user->thumbnail)){{ $user->thumbnail }}@else{{ asset("images/default_user.jpg") }}@endif">
                            
                        </label>

                    </div>
                      
                  </div>
                  
                  <div class="p-form__item">
                      <h2 class="p-form__title">ユーザ名</h2>
                      <div class="p-form__content">
                        <p class="p-form__input--text p-form__input--text-show">
                            {{ $user->name }}
                        </p>

                      </div>
                  </div>

                  <div class="p-form__item">
                      <h2 class="p-form__title">自己紹介</h2>

                      <div class="p-form__content">
                          <p id="description" class="p-form__input--textarea p-form__input--textarea-show" >
                            {{ $user->description }}
                            <span class="p-form__input--textarea-show--empty">
                                @empty($user->description)
                                    まだ記入されていません
                                @endempty
                            </span>
                            
                          </p>
                          
                          
                      </div>
                  </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
