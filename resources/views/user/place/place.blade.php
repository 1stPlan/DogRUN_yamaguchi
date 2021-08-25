@extends('user.layouts.app_user')
@section('title','DogRUN | 検索')

@section('meta')
@endsection

@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('css/page/user/place.css') }}">
@endsection

@section( 'script' )
@endsection

@section('content')

<section class="place">

  <div class="place__page_header">
    <h3 class="place__page_title">DOGRUN</h3>
    <span class="place__page_exp">【 山口県限定 】</span>
  </div>

  <div class="place__inner">


    <div class="place__cont">
      <div class="place__area-filter">
        <p class="place__area-filter-title">エリアから探す</p>
        <a href="{{ route('user.place.result', ['result' => 'position' ]) }}" class="place__search-btn">現在地から探す </a><i class="fa-solid fa-map-location-dot"></i>

        <div class="place__area-btn--flex">

          <div class="place__area-btn place__area-btn--big">
            <a href="{{ route('user.place.result', ['result' => 'all' ]) }}">山口県<br>全域検索</a>
          </div>

          <div class="place__area-list">
            <div class="place__area-btn place__area-btn--all">
              <a href="{{ route('user.place.result', ['result' => 'all' ]) }}">山口県 全域検索</a>
            </div>
            <div class="place__area-btn place__area-btn--yamaguchi">
              <a href="{{ route('user.place.result', ['result' => 'yamaguchi' ]) }}">山口</a>
            </div>
            <div class="place__area-btn place__area-btn--shimonoseki">
              <a href="{{ route('user.place.result', ['result' => 'shimonoseki' ]) }}">下関</a>
            </div>
            <div class="place__area-btn place__area-btn--houhu">
              <a href="{{ route('user.place.result', ['result' => 'houhu' ]) }}">防府</a>
            </div>
            <div class="place__area-btn place__area-btn--hagi">
              <a href="{{ route('user.place.result', ['result' => 'hagi' ]) }}">萩</a>
            </div>
            <div class="place__area-btn place__area-btn--syuunan">
              <a href="{{ route('user.place.result', ['result' => 'syuunan' ]) }}">周南</a>
            </div>
            <div class="place__area-btn place__area-btn--ubeonoda">
              <a href="{{ route('user.place.result', ['result' => 'ubeonoda' ]) }}">宇部・小野田</a>
            </div>
            <div class="place__area-btn place__area-btn--iwakunihikari">
              <a href="{{ route('user.place.result', ['result' => 'iwakunihikari' ]) }}">岩国・光</a>
            </div>
          </div>
        </div>
      </div>

      <div class="place__filter-checkbox">

        <form action="{{ route('user.place.result', ['result' => 'all' ]) }}">
          <div class="place__search-key-word">
            <div class="place__title-key-word">キーワードで探す</div>
            <div class="place__input-key-word">
              <input type="search" name="keyword" id="keyword" placeholder="地名・店舗名を入力">
            </div>
          </div>
          <div class="place__checkbox-services">
            <div class="place__title-key-word"> 条件で絞り込んで探す </div>
            <div class="place__list-services">

              <label class="place__my-checkbox">
                <input type="checkbox" name="services_1" value="cafe">
                <span class="place__checkmark"></span>
                カフェスペース有
              </label>

              <label class="place__my-checkbox">
                <input type="checkbox" name="services_2" value="indoor" id="servicesIndoor">
                <span class="place__checkmark"></span>
                室内ドッグラン有
              </label>

              <label class="place__my-checkbox">
                <input type="checkbox" name="services_3" value="kasikiri" id="servicesKasikiri">
                <span class="place__checkmark"></span>
                貸し切り可能
              </label>

            </div>
          </div>
          <div class="place__button-filter">
            <button class="place__button-search" id="btnSearch"> このキーワード・絞り込みで検索</button>
            <input class="place__button-filter-clear" type="reset" value="リセット">
          </div>
        </form>
      </div>
    </div>

  </div>

</section>


@endsection