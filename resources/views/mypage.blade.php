@extends('layouts.app')

@section('title','マイページ')

@section('side_content')
<div class="p-mypage__menu">
    <section class="p-mypage__thumbnail">
        <div class="c-badge--mypage">
            <div class="c-badge__content--mypage">
                <a href="{{ route('profile') }}">
                    <img class="c-badge__img" src="@if(!empty(Auth::user()->thumbnail)){{ Auth::user()->thumbnail }}@else{{ asset("images/default_user.jpg") }}@endif" alt="">
                </a>
            </div>  
        </div>
        <div class="p-mypage__thumbnail__name">
            {{ Auth::user()->name }}
        </div>
    </section>

    <nav class="p-mypage__nav">
        <ul class="p-mypage__nav-list">
            <li>
                <a href="{{ route('mypage') }}" class="p-mypage__nav-list__item">
                    <i class="fas fa-tachometer-alt"></i>
                    <span class="p-mypage__nav-list__item__text">
                        マイページ
                    </span>
                    
                </a>
                
            </li>
            <li>
                <a href="{{ route('message') }}" class="p-mypage__nav-list__item">
                    <i class="fas fa-envelope"></i>
                    <span class="p-mypage__nav-list__item__text">
                        メッセージ
                    </span>
                </a>
            </li>
            <li>
                <a href="{{ route('works.index') }}" class="p-mypage__nav-list__item">
                    <i class="fas fa-briefcase"></i>
                    <span class="p-mypage__nav-list__item__text">
                        案件を探す
                    </span>
                </a>
            </li>
            <li>
                <a href="{{ route('works.create') }}" class="p-mypage__nav-list__item">
                    <i class="fas fa-file-alt"></i>
                    <span class="p-mypage__nav-list__item__text">
                        案件を登録する
                    </span>
                </a>
            </li>
            <li>
                <a href="{{ route('profile') }}" class="p-mypage__nav-list__item">
                    <i class="fas fa-address-card"></i>
                    <span class="p-mypage__nav-list__item__text">
                        プロフィール編集
                    </span>
                    
                </a>
                
            </li>
        </ul>
    </nav>
</div>

@endsection

@section('content')
<div class="p-mypage l-container">
    <div class="p-mypage__header l-page__header"><h1>{{ __('Mypage') }}</h1></div>
    <div class="p-mypage__contents">

        <section class="p-mypage__tab">
            <ul class="c-tab js-tab_labels">
                <li class="js-tab_label c-tab__label is-active">
                    <h3>登録案件</h3>
                </li>
                <li class="js-tab_label c-tab__label">
                    <h3>応募案件</h3>
                </li>
            </ul>
            <div class="c-tab__content p-mypage__tab-content js-tab_panels">
                <ul class="c-tab__panel is-active js-tab_panel">
                    @if ($posted_works->count() === 0)
                        <li class="c-tab__panel-item-not-found">
                            登録された案件はありません
                        </li>
                    @endif
                    
                    @foreach ($posted_works as $work)
                        <li>
                            <work-item 
                                v-bind:work="{{$work}}"
                                v-bind:apply_count="{{ $work->applyUsers()->count() }}"
                                v-bind:post_flg="{{ ($work->user_id === Auth::id()) ? 1 : 0 }}"
                                >
                            </work-item>
                        </li>
                    @endforeach
                    
                </ul>
                <ul class="c-tab__panel js-tab_panel">
                    @if ($applied_works->count() === 0)
                        <li class="c-tab__panel-item-not-found">
                            応募した案件はありません
                        </li>
                    @endif

                    @foreach ($applied_works as $work)
                        <li>
                            <work-item 
                                v-bind:work="{{$work}}"
                                v-bind:apply_count="{{ $work->applyUsers()->count() }}"
                                v-bind:user="{{ $work->postUser }}"
                                v-bind:post_flg="{{ ($work->user_id === Auth::id()) ? 1 : 0 }}"
                                >
                            </work-item>
                        </li>
                    @endforeach
                </ul>
            </div>
        </section>

    </div>
    
</div>

@endsection
