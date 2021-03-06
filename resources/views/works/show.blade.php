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
        {{ $work->single_price_min }}円 ~ 
        {{ $work->single_price_max }}円
      </span>
    @elseif($work->type_id === $type['revsh'])
      <span class="p-work__type c-worktype">
        <span class="c-worktype__text">レベニューシェア</span>
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
    <li class="c-social__item">
      <a class="c-social__link c-icon c-icon--facebook" href="https://www.facebook.com/sharer.php?u={{ route('works.show',$work->id) }}" rel="nofollow" target="_blank"></a>
    </li>
    <li class="c-social__item">
      <a class="c-social__link c-icon c-icon--hatena" href="https://b.hatena.ne.jp/add?mode=confirm&url={{ route('works.show',$work->id) }}&title={{ $work->title }}" rel="nofollow" target="_blank"></a>
    </li>
     
  </ul>

  <a href="{{ route('works.like',$work->id) }}" 
    class="c-btn--like @if($work->likeUsers()->where('user_id',Auth::id())->exists()) is-liked @endif">
    <i class="far fa-heart"></i>
    <span>いいね</span>
    <span>{{ $work->likeUsers()->count() }}</span>
  </a>

  @if ($work->user_id !== Auth::id())
    @auth
      <form method="POST" action="{{ route('works.apply',['work_id' => $work->id, 'user_id' => $work->user_id]) }}">
        @csrf

        <section class="p-work__btn">
          <button type="submit" class="c-btn c-btn--medium @if($is_applied) c-btn--apply--disabled @else c-btn--apply @endif">
            @if($is_applied) 応募を取り消す @else 応募する @endif
          </button>
        </section>

        @if ($is_applied)
            <section class="p-work__btn">
              <a class="c-btn c-btn--medium c-btn--apply" href="{{ route('message.show',['message_type' => 'direct', 'w' => $work->id, 'u' => $work->user_id]) }}">
                投稿者にメッセージする
              </a>
            </section>
        @endif
        
        
      </form>

    @else
      <section class="p-work__btn">
        <a class="c-btn c-btn--medium c-btn--apply" href="{{ route('register') }}">
          登録して応募する
        </a>
      </section>
    @endauth
    
  @else

  <section class="p-work__btn">
    <a class="p-work__btn__item c-btn c-btn--medium c-btn--edit" href="{{ route('works.edit',$work->id) }}">
      編集
    </a>

    <form action="{{ route('works.delete',$work->id) }}" method="POST" class="p-work__btn__item">
      @csrf
      <button class="c-btn c-btn--medium c-btn--destroy" onclick='return confirm("この案件を削除しますか？");' >
        削除
      </button>
    </form>
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
