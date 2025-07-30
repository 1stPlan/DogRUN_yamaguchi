@extends('user.layouts.app_user')
@section('title','ログイン')

@section('css')
<link rel="stylesheet" href="{{ asset('css/page/auth/login.css') }}">
<style>
.btn-google {
  background: #4285f4;
  color: white;
  border: none;
  padding: 10px 20px;
  border-radius: 5px;
  text-decoration: none;
  display: inline-block;
  transition: background-color 0.3s ease;
}

.btn-google:hover {
  background: #357ae8;
  color: white;
  text-decoration: none;
}

.btn-google i {
  margin-right: 8px;
}
</style>
@endsection

@section('js')
@endsection

@section('content')
<div class="login">
  <div class="login__inner">

    <div class="login__cont">

      <a class="login__logo" href="/">
        <img src="{{ asset('/images/icon.png') }}" alt="logo" width="100%">
      </a>

      <form method="POST" action="{{ route('login') }}" class="login__form">
        {{ csrf_field() }}

        <div class="row">

          <div class="col-10 mx-auto form-group">
            <label class="sr-only" for="email">メールアドレス</label>
            <div class="input-group">
              <div class="input-group-prepend">
                <div class="input-group-text">
                  <i class="far fa-envelope"></i>
                </div>
              </div>
              <input id="email" type="email"
                class="form-control @error('email') is-invalid @enderror" name="email"
                value="{{ old('email') }}" required autocomplete="email" placeholder="メールアドレス">
            </div>
            @error('email')
            <span class="invalid-feedback d-block" role="alert">
              <strong>{{ $message }}</strong>
            </span>
            @enderror
          </div>

          <div class="col-10 mx-auto form-group">
            <label class="sr-only" for="password">パスワード</label>
            <div class="input-group">
              <div class="input-group-prepend">
                <div class="input-group-text">
                  <i class="fas fa-key"></i>
                </div>
              </div>
              <input id="password" type="password"
                class="form-control @error('password') is-invalid @enderror" name="password"
                value="{{ old('password') }}" required autocomplete="password" placeholder="パスワード">
            </div>
            @error('password')
            <span class="invalid-feedback d-block" role="alert">
              <strong>{{ $message }}</strong>
            </span>
            @enderror
            <p class="login__txt"><a href="{{ route('password.request') }}" class="">パスワードを忘れた方はこちら</a></p>
          </div>

          <button class="login__btn btn col-md-5 col-8" type="submit" value="">ログイン</button>

        </div>

      </form>

      <!-- Googleログインボタン -->
      <div class="row mt-3">
        <div class="col-12 text-center">
          <p class="text-muted">または</p>
          <a href="{{ route('google.auth') }}" class="btn btn-google">
            <i class="fab fa-google"></i> Googleでログイン
          </a>
        </div>
      </div>

      <div class="row">
        <div class="login__register-txt col-12">
          初めてご利用の方はこちら
        </div>

        <a href="{{ route('register') }}" class="login__btn btn col-md-5 col-8">新規会員登録</a>
      </div>

    </div>

  </div>
</div>
@endsection