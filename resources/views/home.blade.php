@extends('user.layouts.app_user')
@section('title','DogRUN - 山口県ドッグラン検索・情報サイト')

@section('description','山口県内のドッグラン情報をどこよりも詳しく掲載！施設の特徴や利用料金、アクセス情報から、ユーザーの評価やレビューまで、愛犬とのお出かけに役立つリアルな情報が満載です。山口県のペットライフをもっと充実させたい方におすすめのドッグラン情報サイト')

@section('keywords','山口県,ドッグラン,山口市,防府市,宇部市,下関市,山口ドッグラン,yamaguchi,dogrun,ペット,犬,お出かけ')

@section('h1')
<h1 class="sr-only">DogRUN - 山口県ドッグラン検索・情報サイト</h1>
@endsection

@section('meta')
<!-- Structured Data -->
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "WebSite",
  "name": "DogRUN",
  "description": "山口県内のドッグラン情報をどこよりも詳しく掲載！施設の特徴や利用料金、アクセス情報から、ユーザーの評価やレビューまで、愛犬とのお出かけに役立つリアルな情報が満載です。",
  "url": "{{ url('/') }}",
  "potentialAction": {
    "@type": "SearchAction",
    "target": "{{ url('/user/place') }}",
    "query-input": "required name=search_term_string"
  },
  "publisher": {
    "@type": "Organization",
    "name": "DogRUN",
    "url": "{{ url('/') }}"
  }
}
</script>
@endsection

@section( 'css' )
<link rel="stylesheet" type="text/css" href="{{ asset('css/page/home.css') }}">
@endsection

@section( 'script' )
<script src="https://cdnjs.cloudflare.com/ajax/libs/bodymovin/5.6.6/lottie.min.js" type="text/javascript"></script>
@endsection

@section('content')

<div id="container">

  <section class="mainvisual" id="mainvisual">
    <div class="mainvisual__bg">
      <div class="mainvisual__inner">
        <div class="mainvisual__cont">
          <div class="mainvisual__left">
            <h3 class="mainvisual__sub-ttl">
              <img class="mainvisual__logo" src="{{ asset('/images/icon.png') }}" alt="DogRUNロゴ">
              <span>DogRun</span>
            </h3>
            <h2 class="mainvisual__main-ttl">山口県 ドッグラン<br />検索・情報</h2>
            <p class="mainvisual__desc">一番近い場所を素早く検索</p>

            <div class="mainvisual__btn-box">
              <a class="mainvisual__btn" href="{{ route('login') }}" aria-label="ログインページへ">ログイン</a>
              <a class="mainvisual__btn" href="{{ route('top') }}" aria-label="ドッグラン検索ページへ">検索</a>
            </div>
          </div>
          <div class="mainvisual__right">
            <img class="mainvisual__img" src="{{ asset('/images/mainvisual.jpg') }}" alt="山口県ドッグラン検索サイトのメインビジュアル" width="100%">
          </div>
        </div>
      </div>
    </div>
  </section>

  @endsection