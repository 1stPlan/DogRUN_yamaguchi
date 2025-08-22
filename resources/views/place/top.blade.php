@extends('user.layouts.app_user')
@section('title', '山口県ドッグラン検索 | DogRUN')

@section('description',
    '山口県内のドッグランをエリア別・条件別で検索できます。山口市、下関市、防府市、萩市、周南市、宇部市、小野田市、岩国市、光市のドッグラン情報を掲載。カフェスペース、室内ドッグラン、貸し切り可能な施設も検索可能。')

@section('keywords', '山口県,ドッグラン,検索,山口市,下関市,防府市,萩市,周南市,宇部市,小野田市,岩国市,光市,カフェ,室内ドッグラン,貸し切り')

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
        "name": "ドッグラン検索",
        "item": "{{ url('/') }}"
      }
    ]
  }
}
</script>
@endsection

@section('css')
@endsection

@section('script')
    <!-- Google Maps API -->
    <script async defer
        src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google.maps_api_key') }}&loading=async&language=ja">
    </script>
    @vite('resources/js/components/locationSearch.js')
    @vite('resources/js/components/googleMaps.js')
@endsection

@section('content')

    <div class="top">

        <div class="top__page_header">
            <h2 class="top__page_title">DOGRUN</h2>
            <span class="top__page_exp">【 山口県のドッグラン情報を素早く検索 】</span>
        </div>



        <!-- 山口県ドッグラン情報セクション -->
        <section class="top-info">
            <div class="top__inner">

                <div class="top-info__features">
                    <div class="top-info__feature">
                        <picture>
                            <img src="{{ asset('/images/area.jpg') }}" alt="area" width="100%">
                        </picture>
                        <h3><i class="fas fa-map-marker-alt"></i> エリア別検索</h3>
                        <p>お住まいの地域に近いドッグランを簡単に見つけることができ、お出かけ前に知っておきたい情報を網羅しています。</p>
                    </div>
                    <div class="top-info__feature">
                        <picture>
                            <img src="{{ asset('/images/like.jpg') }}" alt="like" width="100%">
                        </picture>
                        <h3><i class="fas fa-star"></i> ユーザー評価</h3>
                        <p>実際に利用された方からの口コミや評価を参考に、安心してドッグランを選ぶことができます。</p>
                    </div>
                    <div class="top-info__feature">
                        <picture>
                            <img src="{{ asset('/images/event.jpg') }}" alt="event" width="100%">
                        </picture>
                        <h3><i class="fas fa-calendar-alt"></i> イベント検索</h3>
                        <p>山口県内のドッグランに関するイベントを検索できます。</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- 山口県全域セクション -->
        <section class="top-overview">


            <div class="top__inner">
                <h2 class="top__title">山口県のドッグラン情報</h2>

                <p class="top-overview__description">
                    山口県内には愛犬と一緒に楽しめるドッグランが多数あります。各施設の特徴や利用料金、アクセス情報を詳しくご紹介しています。
                </p>
                <div class="top-overview__picture">
                    <picture>
                        <img src="{{ asset('/images/area.jpg') }}" alt="area" width="100%">
                    </picture>
                </div>
                <div class="top-overview__content">

                    <div class="top-overview__map">
                        <div class="top-overview__map-title">
                            現在の県内ドッグラン数:<br><span> {{ $dogrunCount }}</span> 箇所
                        </div>
                        <div class="top-overview__map-container">

                            <div class="top-overview__map-google">
                                <!-- 山口県の地図がここに表示されます -->
                                <div id="google-map" class="google-map">
                                    <div
                                        style="display: flex; align-items: center; justify-content: center; height: 100%; color: #666;">
                                        地図を読み込み中...
                                    </div>
                                </div>
                            </div>
                            <div class="top-overview__map-tooltip" id="map-tooltip"></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>


        <!-- 現在地から検索セクション -->
        <section class="top-search">
            <div class="top__inner">
                <h2 class="top__title">現在地から検索</h2>
                <div class="top-search__content">
                    <div class="top-search__description">
                        <p>お使いのデバイスの位置情報を利用して、現在地から近いドッグランを検索できます。</p>
                    </div>
                    <div class="top-search__button">
                        <button type="button" class="btn btn--primary" onclick="getCurrentLocation()">
                            <i class="fas fa-map-marker-alt"></i>
                            現在地から検索
                        </button>
                    </div>
                    <div class="top-search__result" id="location-result" style="display: none;">

                        <div class="top-search__nearby">
                            <h3>近くのドッグラン</h3>
                            <div id="nearby-dogruns"></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- おすすめドッグランセクション -->
        <section class="top-filter">
            <div class="top__inner">
                <h2 class="top__title">エリア別おすすめのドッグラン</h2>
                <div class="top-filter__list">

                    <div class="top-filter__item">
                        <a href="{{ route('place.result', ['result' => 'hagi']) }}" aria-label="萩市のドッグランを検索">
                            <img src="{{ asset('/images/area/hagi.jpg') }}" alt="萩エリアのドッグラン" class="top-filter__image">
                            <div class="top-filter__content">
                                <h3>萩エリア</h3>
                                <p>歴史的な街並みと自然が調和した萩エリア。愛犬と一緒に散策しながらドッグランで遊ぶことができます。</p>
                            </div>
                        </a>
                    </div>

                    <div class="top-filter__item">
                        <a href="{{ route('place.result', ['result' => 'shimonoseki']) }}" aria-label="下関市のドッグランを検索">
                            <img src="{{ asset('/images/area/shimonoseki.jpg') }}" alt="下関エリアのドッグラン"
                                class="top-filter__image">
                            <div class="top-filter__content">
                                <h3>下関エリア</h3>
                                <p>関門海峡を望む下関エリア。海辺のドッグランで愛犬と一緒に海風を感じながら遊ぶことができます。</p>
                            </div>
                        </a>
                    </div>

                    <div class="top-filter__item">
                        <a href="{{ route('place.result', ['result' => 'houhu']) }}" aria-label="防府市のドッグランを検索">
                            <img src="{{ asset('/images/area/houhu.jpg') }}" alt="防府エリアのドッグラン" class="top-filter__image">
                            <div class="top-filter__content">
                                <h3>防府エリア</h3>
                                <p>防府天満宮周辺のドッグラン。神社参拝のついでに愛犬と一緒にドッグランで遊ぶことができます。</p>
                            </div>
                        </a>
                    </div>

                    <div class="top-filter__item">
                        <a href="{{ route('place.result', ['result' => 'yamaguchi']) }}" aria-label="山口市のドッグランを検索">
                            <img src="{{ asset('/images/area/yamaguchi.jpg') }}" alt="山口エリアのドッグラン"
                                class="top-filter__image">
                            <div class="top-filter__content">
                                <h3>山口エリア</h3>
                                <p>県庁所在地である山口エリア。市内のドッグランで愛犬と一緒に快適に遊ぶことができます。</p>
                            </div>
                        </a>
                    </div>

                    <div class="top-filter__item">
                        <a href="{{ route('place.result', ['result' => 'iwakunihikari']) }}" aria-label="岩国市のドッグランを検索">
                            <img src="{{ asset('/images/area/iwakuni.jpg') }}" alt="岩国エリアのドッグラン" class="top-filter__image">
                            <div class="top-filter__content">
                                <h3>岩国エリア</h3>
                                <p>錦帯橋で有名な岩国エリア。歴史的な景観を楽しみながら愛犬とドッグランで遊ぶことができます。</p>
                            </div>
                        </a>
                    </div>

                    <div class="top-filter__item">
                        <a href="{{ route('place.result', ['result' => 'syuunan']) }}" aria-label="周南市のドッグランを検索">
                            <img src="{{ asset('/images/area/syuunan.jpg') }}" alt="周南エリアのドッグラン"
                                class="top-filter__image">
                            <div class="top-filter__content">
                                <h3>周南エリア</h3>
                                <p>工業都市として発展した周南エリア。愛犬と一緒にドッグランで遊びながら街の魅力を発見できます。</p>
                            </div>
                        </a>
                    </div>

                    <div class="top-filter__item">
                        <a href="{{ route('place.result', ['result' => 'ubeonoda']) }}" aria-label="宇部市のドッグランを検索">
                            <img src="{{ asset('/images/area/ube.jpg') }}" alt="宇部エリアのドッグラン" class="top-filter__image">
                            <div class="top-filter__content">
                                <h3>宇部エリア</h3>
                                <p>海と山に囲まれた宇部エリア。自然豊かな環境で愛犬と一緒にドッグランを楽しむことができます。</p>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="top-filter__checkbox">
                    <form action="{{ route('place.result', ['result' => 'all']) }}">
                        <div class="top-filter__search-key-word">
                            <div class="top-filter__title-key-word">キーワードで探す</div>
                            <div class="top-filter__input-key-word">
                                <input type="search" name="keyword" id="keyword" topholder="地名・店舗名を入力"
                                    aria-label="ドッグラン検索キーワード">
                            </div>
                        </div>
                        <div class="top-filter__checkbox-services">
                            <div class="top-filter__title-key-word"> 条件で絞り込んで探す </div>
                            <div class="top-filter__list-services">

                                <label class="top-filter__my-checkbox">
                                    <input type="checkbox" name="services_1" value="cafe">
                                    <span class="top-filter__checkmark"></span>
                                    カフェスペース有
                                </label>

                                <label class="top-filter__my-checkbox">
                                    <input type="checkbox" name="services_2" value="indoor" id="servicesIndoor">
                                    <span class="top-filter__checkmark"></span>
                                    室内ドッグラン有
                                </label>

                                <label class="top-filter__my-checkbox">
                                    <input type="checkbox" name="services_3" value="kasikiri" id="servicesKasikiri">
                                    <span class="top-filter__checkmark"></span>
                                    貸し切り可能
                                </label>

                            </div>
                        </div>
                        <div class="top-filter__button-filter">
                            <button class="top-filter__button-search" id="btnSearch" type="submit"
                                aria-label="このキーワード・絞り込みでドッグランを検索"> このキーワード・絞り込みで検索</button>
                            <input class="top-filter__button-filter-clear" type="reset" value="リセット">
                        </div>
                    </form>
                </div>

            </div>
        </section>

        <!-- ドッグラン利用のコツセクション -->
        <section class="top-tips">
            <div class="top__inner">
                <h2 class="top__title">ドッグラン利用のコツ</h2>
                <div class="top-tips__content">
                    <div class="top-tips__tip">
                        <h3>事前準備</h3>
                        <ul>
                            <li>愛犬の健康状態を確認</li>
                            <li>必要な持ち物（リード、おもちゃ、水など）を準備</li>
                            <li>利用時間や料金を事前に確認</li>
                        </ul>
                    </div>

                    <div class="top-tips__tip">
                        <h3>利用時の注意点</h3>
                        <ul>
                            <li>他の犬との相性を確認</li>
                            <li>愛犬の様子を常に観察</li>
                            <li>施設のルールを守る</li>
                        </ul>
                    </div>

                    <div class="top-tips__tip">
                        <h3>帰宅後</h3>
                        <ul>
                            <li>愛犬の体を清潔にする</li>
                            <li>水分補給を十分に行う</li>
                            <li>疲れていないか確認</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

    </div>

@endsection
