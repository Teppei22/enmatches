@extends('layouts.app')

@section('title','案件一覧')

@section('content')
    <div class="p-works l-container">
      <div class="p-works__container">
        <div class="p-works__header l-container__header">
          <h1>{{ __('Works') }}</h1>
        </div>
        <div class="p-works__contents">
          <form class="p-works__search" method="get" action="{{ route('works.index') }}">

            <div class="p-works__search__tools">
              <div class="p-works__search__keyword">
                  <input class="p-works__search__keyword__text" type="text" name="keyword" placeholder="キーワードを入力" value="{{ session('keyword') }}">
                <button class="p-works__search__keyword__btn">
                  検索
                </button>
              </div>
            </div>

            <div class="p-works__search__tools">
              <h3 class="p-works__search__tools__title">案件種類で絞る</h3>
              <div class="c-radio">
                <label class="c-radio__label">
                  <input type="radio" name="sort" value="single" {{ (session('sort') === 'single') ? 'checked' : '' }}>
                  <span class="c-radio__text">
                    単発案件
                  </span>
                </label>
              </div>
              <div class="c-radio">
                <label class="c-radio__label">
                  <input type="radio" name="sort" value="revsh" {{ (session('sort') === 'revsh') ? 'checked' : '' }}>
                  <span class="c-radio__text">
                    レベニューシェア
                  </span>
                </label>
              </div>
              <div class="c-radio">
                <label class="c-radio__label">
                  <input type="radio" name="sort" value="single_revsh" {{ (session('sort') === 'single_revsh') ? 'checked' : '' }}>
                  <span class="c-radio__text">
                    すべて
                  </span>
                </label>
              </div>
              
            </div>

            <div class="p-works__search__tools">
              <h3 class="p-works__search__tools__title">単発案件の報酬金額で絞る</h3>
              <div class="p-works__search__price">
                <input class="p-works__search__price__number" type="number" name="min_price" step="1000" value="{{ session('min_price') }}"> 円以上 ~ 
                <br>
                <input class="p-works__search__price__number" type="number" name="max_price" step="1000" value="{{ session('max_price') }}"> 円以下
                
              </div>
              
            </div>

            <div class="p-works__search__tools">
              <p class="p-works__search__link">
                <a href="{{ route('works.index') }}">検索条件を消去</a>
              </p>
            </div>

            <div class="p-works__search__tools__search-btn">
              <button class="c-btn c-btn--medium c-btn--search" type="submit">絞り込む</button>
            </div>
            
            
          </form>

          @if ($works->count() === 0)
            <section class="p-works__list--empty">
              <p class="p-works__list--empty__description">
                お探しの案件は見つかりませんでした<br>
                条件を変えて再検索してください。
              </p>
              
            </section>
          @else
            <section class="p-works__list">
              
              @foreach($works as $work)
                <work-item 
                  v-bind:work="{{$work}}"
                  v-bind:apply_count="{{ $work->applyUsers()->count() }}"
                  v-bind:post_user="{{ $work->postUser }}"
                  @auth
                    v-bind:login_user="{{ Auth::user() }}"
                    v-bind:post_flg="{{ ($work->user_id === Auth::id()) ? 1 : 0 }}"
                  @else
                    v-bind:login_user=null
                    v-bind:post_flg=0
                  @endauth
                  
                  >
                  </work-item>
              @endforeach
              
            </section>
          @endif
          
          <div class="p-works__pagination">
            {{ $works->links() }}
          </div>

          
        </div>
      </div>
    </div>
@endsection