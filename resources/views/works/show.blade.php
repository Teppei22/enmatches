@extends('layouts.app')

@section('title',$work->title)

@section('description')ネットでお手軽発注の{{ config('app.name', 'Laravel') }}です。「{{ $work->title }}」に応募できます！報酬:@if(is_null($work->revenue_share_price)){{ $work->single_price_min }}円 ~ {{ $work->single_price_max }}円@else{{ $work->revenue_share_price }}円@endif
@endsection

@section('keywords','')

@section('content')
<div class="p-work l-container">
  <div class="p-work__header l-container__header">
    <h1 class="p-work__title">{{ $work->title }}</h1>
  </div>

  <p class="p-work__date">
    募集開始日:
    <span class="p-work__date__text">
      {{ substr((string)$work->created_at,0,16) }}
    </span>
    
  </p>

  <div class="p-work__price">
    @if ($work->type_id === $type['single'])
      <span class="p-work__type c-worktype">
        <span class="c-worktype__text">個人開発</span>
      </span>
      <span class="c-workPrice">
        {{ $work->single_price_min }} ~ 
        {{ $work->single_price_max }}円
      </span>
    @elseif($work->type_id === $type['revsh'])
      <span class="p-work__type c-worktype">
        <span class="c-worktype__text">レベニューシェア</span>
      </span>
      
      <span class="c-workPrice">
        {{ $work->revenue_share_price }}円
      </span>
    @endif
    
  </div>

  <div class="c-workDetail">
    <div class="c-workDetail__description">{{ $work->detail }}</div>
  </div>

  <ul class="c-social-list">
    <li class="c-social__item">
      <a class="c-social__link c-icon c-icon--twitter" href="https://twitter.com/intent/tweet?url={{ route('works.show',$work->id) }}&text={{ $work->title }}%0a" rel="nofollow" target="_blank"></a>
    </li>
     
  </ul>

  @if ($work->user_id !== Auth::id())
    @auth
      <form method="POST" action="{{ route('work.apply','direct') }}">
        @csrf
        <input type="hidden" name="work_id" value="{{ $work->id }}">
        <input type="hidden" name="user_id" value="{{ $work->user_id }}">

        <section class="p-work__btn">
          <button type="submit" class="c-btn c-btn--medium c-btn--apply" @if($is_applied) disabled @endif>
            @if($is_applied) 応募済み @else 応募する @endif
          </button>
        </section>

        @if ($is_applied)
            <section class="p-work__btn">
              <button class="c-btn c-btn--medium c-btn--apply">
                <a href="{{ route('message.show',['message_type' => 'direct', 'w' => $work->id, 'u' => $work->user_id]) }}">投稿者にメッセージする</a>
              </button>
            </section>
        @endif
        
        
      </form>

    @else
      <section class="p-work__btn">
        <button class="c-btn c-btn--medium c-btn--apply">
          <a href="{{ route('register') }}">登録して応募する</a>
        </button>
      </section>
    @endauth
    
  @else

  <section class="p-work__btn">
    <button class="c-btn c-btn--medium c-btn--edit">
      <a href="{{ route('works.edit',$work->id) }}">編集</a>
    </button>
  </section>
    
  @endif
  
  <message-item
    message_type="public"
    @auth
      :self_user_id="{{ Auth::id() }}"
    @endauth
    :work="{{ $work }}">
  </message-item>

</div>
@endsection
