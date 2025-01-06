@extends('user.layouts.app_user')
@section('title', '会員登録完了')

@section('css')
<link rel="stylesheet" href="{{ asset('css/page/user/setting/setting_withdrawal.css') }}">
@endsection

@section('js')
@endsection

@section('content')
<section class="withdrawal">
  <div class="withdrawal__inner">

    <div class="withdrawal__cont">
      <a class="withdrawal__logo" href="/">
        <img src="{{ asset('/images/icon.png') }}" alt="logo" width="100%">
      </a>
      <h3 class="withdrawal__ttl">退会</h3>

      <div class="withdrawal__text">
        退会ページです。<br>退会されますと、登録情報が全て削除されます。<br>ご了承の上、手続きにお進みください。
      </div>

      <div class="form-group withdrawal__btn-box">
        <form method="post" action="{{ action('User\SettingController@withdrawal_complate',$user->id) }}">
          {{ csrf_field() }}
          {{ method_field('delete') }}

          <button type="submit" class="withdrawal__btn d-block col-md-5 col-6 btn-primary" data-dismiss="modal">退会する</button>

          <a href="{{ route('user.setting') }}" class="withdrawal__mypage-btn d-block col-md-5 col-6 btn-primary">マイページへ戻る</a>
        </form>
      </div>



    </div>

  </div>

  @endsection