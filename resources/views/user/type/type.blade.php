@extends('user.layouts.app_user')
@section('title', 'DogRUN | タイプ診断')

@section('meta')
@endsection


@section('css')
  <link rel="stylesheet" href="{{ asset('css/page/user/type.css') }}">
@endsection

@section('js')
@endsection

@section('content')

<div class="type">
  <div class="type__inner">
    <div class="type__cont">

      <div class="type__cont-flex">
        <h2 class="type__cont-ttl">タイプ診断を開始</h2>
        <div class="type__cont-ttl-img">
          <img src="{{ asset('images/arrow_right.png') }}" alt="" width="100%">
        </div>
      </div>

      <div class="type__cont-btn-box">
        <a href="{{ url('/user/type/select/0/1') }}" class="type__cont-btn btn">スタート</a>
      </div>

    </div>
  </div>
</div>
@endsection
