@extends('user.layouts.app_user')
@section('css')
<link rel="stylesheet" href="{{ asset('css/page/auth/password.css') }}">
@endsection

@section('content')
<div class="password">
    <div class="password__inner">

        <div class="password__cont">

            <a class="password__logo" href="/">
                <img src="{{ asset('/images/icon.png') }}" alt="logo" width="100%">
            </a>

            <h2 class="password__ttl">パスワードリセット</h2>
            @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <div class="col-12 form-group">
                    <label class="sr-only" for="email">メールアドレス</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <i class="far fa-envelope"></i>
                            </div>
                        </div>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="メールアドレス">
                    </div>
                    @error('email')
                    <span class="invalid-feedback d-block" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-group password__btn-box">
                    <button type="submit" class="password__btn btn d-block col-md-5 col-6">
                        メール送信
                    </button>
                    @if( Auth::check() )
                    <a class="password__mypage-btn  btn d-block col-md-5 col-6" href="{{ route('user.setting') }}">マイページへ戻る</a>

                    @else
                    <a class="password__mypage-btn  btn d-block col-md-5 col-6" href="{{ route('login') }}">ログインページへ戻る</a>
                    @endif
                </div>
            </form>
        </div>
    </div>
</div>
@endsection