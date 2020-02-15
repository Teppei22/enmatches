@extends('layouts.app')

@section('description',config('app.name', 'Laravel').'はネットでお手軽にお仕事を発注・受注できるWEBサービスです。ホームページやハードウェア・アプリ制作からバナーやロゴのデザインまで専門性の高い案件を発注できます。今すぐ無料で会員登録してお仕事を発注しましょう')

@section('keywords',config('app.name', 'Laravel').', HP 発注, デザイン 発注, システム開発 発注')

@section('content')
<div class="l-container--wrapper">
  <section class="p-top-hero">
    <div class="p-top-hero__heading">
      
      <span class="p-top-hero__heading__worktype">HP・デザイン・システム開発</span>
      <h2 class="p-top-hero__heading__title">お気軽に<br>発注・受注できます</h2>
      
    </div>
  </section>



  <section class="p-top-section">
    <h2 class="p-top-section__title">
      ご要望に合わせて<br>お手軽に発注できます
    </h2>

    <section class="p-top-panel-list">
      <article class="p-top-panel__item">
        <div class="p-top-panel__head">
          <h2>ホームページ作成</h2>
        </div>
        <div class="p-top-panel__img"> 
          <img src="{{ asset('images/website_image.png') }}" alt="">
        </div>
        <div class="p-top-panel__text">
          <h3>
            ホームページをリニューアルして<br>
            集客できます
          </h3>
        </div>
      </article>
      <article class="p-top-panel__item">
        <div class="p-top-panel__head">
          <h2>プロジェクト開発</h2>
        </div>
        <div class="p-top-panel__img"> 
          <img src="{{ asset('images/service_develop.jpg') }}" alt="">
        </div>
        <div class="p-top-panel__text">
          <h3>
            仲間を募って<br>
            プロジェクトを進めます
          </h3>
        </div>
      </article>
      <article class="p-top-panel__item">
        <div class="p-top-panel__head">
          <h2>バナー開発・デザイン</h2>
        </div>
        <div class="p-top-panel__img"> 
          <img src="{{ asset('images/website_design.png') }}" alt="" style="height: 100%;">
        </div>
        <div class="p-top-panel__text">
          <h3>
            魅力的なデザインで<br>
            売上を上げる
          </h3>
        </div>
      </article>
    </section>
  </section>

  @guest
    <section class="p-top-section">
        <a class="c-btn c-btn--medium c-btn--catch p-top-section--button" href="{{ route('register') }}">
          登録する
        </a>
    </section>

    <section class="c-btn--float js-float-button">
      <a class="c-btn c-btn--medium c-btn--catch c-btn c-btn--float__item" href="{{ route('register') }}">
        登録する
      </a>
      <a class="c-btn c-btn--medium c-btn--login c-btn c-btn--float__item" href="{{ route('login') }}">
        ログイン
      </a>
    </section>

  @endguest
  
  

  <section class="p-top-section --bg-white">
    <h2 class="p-top-section__title">
      {{ config('app.name', 'Laravel') }}のご利用方法
    </h2>

    <section class="p-top-panel-list">
      <article class="p-top-panel__item">
        <div class="p-top-panel__head">
          <h2>STEP.1</h2>
        </div>
        <div class="p-top-panel__img--flow">
          <img src="{{ asset('images/new_member.png') }}" alt="">
        </div>
        <div class="p-top-panel__text">
          <h3>会員登録</h3>
            <p>
              会員登録無料。
              ユーザ名とメールアドレスで簡単登録できます。
            </p>
        </div>
      </article>

      <article class="p-top-panel__item">
        <div class="p-top-panel__head">
          <h2>STEP.2</h2>
        </div>
        <div class="p-top-panel__img--flow">
          <img src="{{ asset('images/hand_shake.jpg') }}" alt="">
        </div>
        <div class="p-top-panel__text">
          <h3>案件を投稿する</h3>
          <p>
            案件名・報酬金額・案件種類(単発案件/レベニューシェア)・案件詳細を入力してお手軽に依頼できます。
          </p>
          <br>
          <div>
            <h4>※案件種類(単発案件/レベニューシェア)とは...</h4>
            <p>
              支払い枠が固定されている<span><a href="{{ route('works.index',['sort'=>'single']) }}">単発案件</a></span>と<br>
              パートナーとして連携し、収益を分配する<span><a href="{{ route('works.index',['sort'=>'revsh']) }}">レベニューシェア</a></span>があります。
            </p>
          </div>
        </div>
      </article>

      <article class="p-top-panel__item">
        <div class="p-top-panel__head">
          <h2>STEP.3</h2>
        </div>
        <div class="p-top-panel__img--flow">
          <img src="{{ asset('images/man-message.png') }}" alt="">
        </div>
        <div class="p-top-panel__text">
          <h3>メッセージ</h3>
            <p>
              会員登録無料
              ユーザ名とメールアドレスで簡単登録
            </p>
        </div>
      </article>
    </section>

  </section>


</div>

@endsection