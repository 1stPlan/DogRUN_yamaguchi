@extends('user.layouts.app_user')
@section('title','DogRUN | 店舗一覧')

@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('css/page/user/place.css') }}">
@endsection

@section('meta')
@endsection

@section( 'script' )
<script src="{{ asset('js/dogFood.js') }}"></script>
@endsection

@section('content')

<div class="result">

  <div class="result__page_header">
    <h3 class="result__page-title">DogFood</h3>
    <span class="result__page_exp">【売り上げランキング】</span>
  </div>

  <div class="result__content">
    <div id="loader" class="result__loader">読み込み中...</div>
    <div class="result__content_flex">
      <div class="result__content_amazon">
        <div id="result__content_amazon">
        </div>
      </div>
      <div class="result__content_yahoo">
        <div id="result__content_yahoo">
        </div>
      </div>
    </div>
  </div>
  <div class="result__store-button">
    <a href="{{ route('top') }}" class="">戻る</a>
  </div>
</div>

@endsection