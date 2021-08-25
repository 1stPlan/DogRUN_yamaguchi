@extends('user.layouts.app_user')

@section('meta')
@endsection

@section('title', '設定終了')

@section('css')
<link rel="stylesheet" href="{{ asset('css/page/auth/type.css') }}">
@endsection

@section('js')
@endsection

@section('content')

<div class="type">
  <div class="type__inner">


    <div class="type__cont">
      <h2 class="type__ttl">設定終了</h2>

      <div class="type__select">

        <div class="type__select-after">
          これで設定が完了しました。
        </div>
      </div>

      <div class="type__cont-btn-box">
        <a href="{{ route('user.setting') }}" class="type__cont-btn btn">マイページ</a>
      </div>

    </div>




  </div>
</div>
</div>

@endsection