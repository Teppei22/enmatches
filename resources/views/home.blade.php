@extends('layouts.app')

@section('content')
<div class="p-profile">
    <div class="p-prifile__header">
        <div class="c-user--icon">
            <a href="">
                <img src="" alt="">
                <h2>{{ Auth::user()->name }}</h2>
                <div class="c-user--number">

                </div>
            </a>
        </div>
    </div>
    
</div>
<section class="p-work__tab">
    <ul class="c-nav">
        <li class="c-nav__item is-active">
            <a class="c-nav__item__anchor" href="">
                <h3>取引中</h3>
            </a>
        </li>
        <li class="c-nav__item is-active">
            <a class="c-nav__item__anchor" href="">
                <h3>過去の取引</h3>
            </a>
        </li>
    </ul>
    <div class="c-tab__content">
        <ul>
            <li>
                
            </li>
        </ul>
    </div>
</section>
@endsection
