@extends('layouts.app')

@section('title', __('Work Edit'))

@section('content')
    @component('form.work')
        @slot('page_title',__('Work Edit'))
        @slot('post_action',route('works.update',$work->id))
        {{-- @slot('form_method','PUT') --}}
        @slot('title_default', $work->title)
        @slot('type_id_default', $work->type_id)
        @slot('work_types', $work_types)
        @slot('single_price_min_default', $work->single_price_min)
        @slot('single_price_max_default', $work->single_price_max)
        @slot('revenue_share_price_default', $work->revenue_share_price)
        @slot('detail_default', $work->detail)
        @slot('submit_word', __('Update'))
    @endcomponent
    
@endsection