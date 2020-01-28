@extends('layouts.app')

@if ($message_type === 'direct')
  @section('title',$partner_user->name.' / '.$work->title)
@elseif ($message_type === 'public')
  @section('title','public'.' / '.$work->title)
@endif

@section('content')

<div class="p-message l-container">
  <div class="p-message__header l-container__header">
    <div class="p-message__link-index">
      <a href="{{ route('message') }}" title="メッセージ一覧">
        <i class="fas fa-chevron-left"></i>
      </a>
    </div>
    
    <h1 class="p-message__title">
      <a href="{{ route('works.show',$work->id) }}">案件 「{{ $work->title }}」</a>
    </h1>
  </div>
  <div class="l-container__header">
    <h2>
      @if ($message_type === 'direct')
        {{ __('Direct Message') }}
      @elseif ($message_type === 'public')
        {{ __('Public Message') }}
      @endif
    </h2>

  </div>

  @if ($message_type === 'direct')
      <h3 class="p-message__destination"><a href="{{ route('profile.show',$partner_user->id) }}"> {{ $partner_user->name   }}</a></h3>
  @endif
  <message-item
    message_type="{{ $message_type }}"
    :self_user_id="{{ Auth::id() }}"
    :partner_user_id="{{ ($message_type === 'direct') ? $partner_user->id : 0 }}"
    :work="{{ $work }}">
  </message-item>

</div>
@endsection
