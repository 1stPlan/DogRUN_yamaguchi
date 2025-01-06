@extends('user.layouts.app_user')
@section('title','DogRUN')

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
              <img class="mainvisual__logo" src="{{ asset('/images/icon.png') }}" alt="logo">
              <span>DogRun</span>
            </h3>
            <h2 class="mainvisual__main-ttl">山口県 ドッグラン<br />検索・情報</h2>
            <p class="mainvisual__desc">一番近い場所を素早く検索</p>

            <div class="mainvisual__btn-box">
              <a class="mainvisual__btn" href="{{ route('login') }}">ログイン</a>
              <a class="mainvisual__btn" href="{{ route('user.place') }}">検索</a>
            </div>
          </div>
          <div class="mainvisual__right">
            <img class="mainvisual__img" src="{{ asset('/images/mainvisual.jpg') }}" alt="mainvisual" width="100%">
          </div>
        </div>
      </div>
    </div>
  </section>


  @endsection