@extends('layouts.app')
@section('content')
    <div class="p-works">
      <div class="p-works__container">
        <div class="p-works__header l-header">
          <h1>{{ __('Works') }}</h1>
        </div>
        <div class="p-works__contents">
          <div class="p-works__section">
            <work-list
              v-bind:works="{{ $works }}"
              v-bind:users="{{ $users }}"
              v-bind:work_types="{{ $work_types }}"
            >
            </work-list>
          </div>
        </div>
      </div>
    </div>
@endsection