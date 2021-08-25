@extends('user.layouts.app_user')
@section('title', '会員登録完了')

@section('css')
<link rel="stylesheet" href="{{ asset('css/page/user/setting/setting_withdrawal.css') }}">
@endsection

@section('content')
<section class="withdrawal">
  <div class="withdrawal__inner">
    <h3 class="withdrawal__title">退会(完了)<</h3>

    <div class="card border-0">

      <div class="row">
        <div class="col-12 mt-5 px-0">
          <p class="text-center mx-md-auto px-0 mb-md-0">
            退会が完了しました。
          </p>
        </div>
      </div>

      <div class="row mb-0 w-100 mx-auto">
        <div class="text-center mt-5 w-100">
          <a href="{{ route('top') }}" class="col-md-5 mx-auto btn green_border btn-block">トップページへ</a>
        </div>
      </div>
    </div>
  </div>
</section>
@include('components.footer_button')
@endsection