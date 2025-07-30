@extends('user.layouts.app_user')
@section('title','DogRUN | 店舗一覧')

@section('css')
@endsection

@section('meta')
@endsection

@section( 'script' )
<script src="{{ asset('js/dogRun.js') }}"></script>
@endsection

@section('content')

<div class="result">

  <div class="result__page-title">{{$place_area}} 検索結果</div>

  <div class="result__content">
    <div class="result__header">
      <label class="result__label">現在　<b id="js-result-count"></b>表示中</label>
    </div>
    <div id="result__content"></div>
  </div>
  <div id="resultNoStore" class="result__nostore"></div>
  <div class="result__store-button">
    <a href="{{ route('top') }}" class="">戻る</a>
  </div>
</div>

@endsection