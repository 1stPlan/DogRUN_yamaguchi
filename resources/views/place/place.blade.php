@extends('user.layouts.app_user')
@section('title','山口県ドッグラン検索 | DogRUN')

@section('description','山口県内のドッグランをエリア別・条件別で検索できます。山口市、下関市、防府市、萩市、周南市、宇部市、小野田市、岩国市、光市のドッグラン情報を掲載。カフェスペース、室内ドッグラン、貸し切り可能な施設も検索可能。')

@section('keywords','山口県,ドッグラン,検索,山口市,下関市,防府市,萩市,周南市,宇部市,小野田市,岩国市,光市,カフェ,室内ドッグラン,貸し切り')

@section('h1')
<h1 class="sr-only">山口県ドッグラン検索</h1>
@endsection

@section('meta')
<!-- Structured Data -->
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "WebPage",
  "name": "山口県ドッグラン検索",
  "description": "山口県内のドッグランをエリア別・条件別で検索できます。山口市、下関市、防府市、萩市、周南市、宇部市、小野田市、岩国市、光市のドッグラン情報を掲載。",
  "url": "{{ url()->current() }}",
  "breadcrumb": {
    "@type": "BreadcrumbList",
    "itemListElement": [
      {
        "@type": "ListItem",
        "position": 1,
        "name": "ホーム",
        "item": "{{ url('/') }}"
      },
      {
        "@type": "ListItem",
        "position": 2,
        "name": "ドッグラン検索",
        "item": "{{ url()->current() }}"
      }
    ]
  }
}
</script>
@endsection

@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('css/page/user/place.css') }}">
@endsection

@section( 'script' )
@endsection

@section('content')

<section class="place">

  <div class="place__page_header">
    <h2 class="place__page_title">DOGRUN</h2>
    <span class="place__page_exp">【 山口県の一番近いドッグランを素早く検索 】</span>
  </div>

  <div class="place__inner">


    <div class="place__cont">
      <div class="place__area-filter">
        <h3 class="place__area-filter-title">エリアから探す</h3>
        <a href="{{ route('place.result', ['result' => 'position' ]) }}" class="place__search-btn" aria-label="現在地からドッグランを探す">現在地から探す </a><i class="fa-solid fa-map-location-dot"></i>

        <div class="place__area-btn--flex">

          <div class="place__area-btn place__area-btn--big">
            <a href="{{ route('place.result', ['result' => 'all' ]) }}" aria-label="山口県全域のドッグランを検索">山口県<br>全域検索</a>
          </div>

          <div class="place__area-list">
            <div class="place__area-btn place__area-btn--all">
              <a href="{{ route('place.result', ['result' => 'all' ]) }}" aria-label="山口県全域のドッグランを検索">山口県 全域検索</a>
            </div>
            <div class="place__area-btn place__area-btn--yamaguchi">
              <a href="{{ route('place.result', ['result' => 'yamaguchi' ]) }}" aria-label="山口市のドッグランを検索">山口</a>
            </div>
            <div class="place__area-btn place__area-btn--shimonoseki">
              <a href="{{ route('place.result', ['result' => 'shimonoseki' ]) }}" aria-label="下関市のドッグランを検索">下関</a>
            </div>
            <div class="place__area-btn place__area-btn--houhu">
              <a href="{{ route('place.result', ['result' => 'houhu' ]) }}" aria-label="防府市のドッグランを検索">防府</a>
            </div>
            <div class="place__area-btn place__area-btn--hagi">
              <a href="{{ route('place.result', ['result' => 'hagi' ]) }}" aria-label="萩市のドッグランを検索">萩</a>
            </div>
            <div class="place__area-btn place__area-btn--syuunan">
              <a href="{{ route('place.result', ['result' => 'syuunan' ]) }}" aria-label="周南市のドッグランを検索">周南</a>
            </div>
            <div class="place__area-btn place__area-btn--ubeonoda">
              <a href="{{ route('place.result', ['result' => 'ubeonoda' ]) }}" aria-label="宇部市・小野田市のドッグランを検索">宇部・小野田</a>
            </div>
            <div class="place__area-btn place__area-btn--iwakunihikari">
              <a href="{{ route('place.result', ['result' => 'iwakunihikari' ]) }}" aria-label="岩国市・光市のドッグランを検索">岩国・光</a>
            </div>
          </div>
        </div>
      </div>

      <div class="place__filter-checkbox">

        <form action="{{ route('place.result', ['result' => 'all' ]) }}">
          <div class="place__search-key-word">
            <div class="place__title-key-word">キーワードで探す</div>
            <div class="place__input-key-word">
              <input type="search" name="keyword" id="keyword" placeholder="地名・店舗名を入力" aria-label="ドッグラン検索キーワード">
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
            <button class="place__button-search" id="btnSearch" type="submit" aria-label="このキーワード・絞り込みでドッグランを検索"> このキーワード・絞り込みで検索</button>
            <input class="place__button-filter-clear" type="reset" value="リセット">
          </div>
        </form>
      </div>
    </div>

  </div>

</section>


@endsection