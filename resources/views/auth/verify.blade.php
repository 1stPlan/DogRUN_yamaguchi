@extends('user.layouts.app_user')
@section('title', '新規会員登録')

@section('meta')
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('css/page/auth/register.css') }}">

@endsection

@section('content')

<div class="register">
  <div class="register__inner">

    <div class="register__cont">

      <a class="register__logo" href="/">
        <img src="{{ asset('/images/icon.png') }}" alt="logo" width="100%">
      </a>

      <div class="mt-5">
        <p class="mx-md-auto mb-5">
          ご入力いただいたメールアドレス宛に、本登録URLをお送りいたしました。メールをご確認いただき、そこから本登録を完了させてください。
        </p>
        <p class="mx-md-auto mb-4">
          メールが届かない場合は、以下の原因が考えられます。
        </p>
        <ul class="mx-auto">
          <li>・迷惑フォルダや別のフォルダに振り分けられている</li>
          <li>・ご入力のメールアドレスが間違えている</li>
        </ul>
      </div>


      <div class="form-group mb-3">

        <a href="{{ route('logout') }}" class="register__btn btn" onclick="event.preventDefault();
              document.getElementById('logout-form').submit();">
          トップページへ
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
          @csrf
        </form>

      </div>


    </div>
  </div>
</div>

@endsection