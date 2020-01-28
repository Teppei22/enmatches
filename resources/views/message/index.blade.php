@extends('layouts.app')

@section('title','メッセージ一覧')

@section('sidebar')
@endsection

@section('content')

<div class="p-message l-container">
  <div class="l-container__header">
    <h2>メッセージ一覧</h2>
    {{-- <h3>{{ $user->name }}</h3> --}}
  </div>
  <message-list
    :self_user="{{ Auth::user() }}"
    :posted_works="{{ $posted_works }}"
    :applied_works="{{ $applied_works }}"
    >
  </message-list>

</div>
@endsection
