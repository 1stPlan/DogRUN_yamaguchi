@extends('user.layouts.app_user')
@section('title', '新規会員登録')

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

                <form method="POST" action="{{ route('register') }}" class="register__form">
                    @csrf

                    <div class="row">

                        <div class="col-12 form-group">
                            <label class="sr-only" for="email">メールアドレス</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text d-flex align-items-center h-100">
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

                        <div class="col-12 form-group mt-2">
                            <label class="sr-only" for="password">パスワード</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text d-flex align-items-center h-100">
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
                        </div>

                        <div class="col-12 form-group mt-2">
                            <label class="sr-only" for="password-confirm">パスワード 確認</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text d-flex align-items-center h-100">
                                        <i class="fas fa-key"></i>
                                    </div>
                                </div>
                                <input id="password-confirm" type="password" class="form-control"
                                    name="password_confirmation" required autocomplete="new-password" placeholder="パスワード確認">
                            </div>
                        </div>
                        <button type="submit" class="register__btn btn">
                            新規作成
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>

@endsection
