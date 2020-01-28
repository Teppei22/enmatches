@extends('layouts.app')

@section('title', __('Work Register'))

@section('content')
    @component('form.work')
        @slot('page_title',__('Work Register'))
        @slot('post_action',route('works.store'))
        {{-- @slot('form_method','POST') --}}
        @slot('title_default', null)
        @slot('type_id_default', null)
        @slot('work_types', $work_types)
        @slot('single_price_min_default', null)
        @slot('single_price_max_default', null)
        @slot('revenue_share_price_default', null)
        @slot('detail_default', null)
        @slot('submit_word', __('Register'))
    @endcomponent
@endsection