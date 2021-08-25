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

            <form method="POST" action="{{ route('password.update') }}">
                @csrf

                <input type="hidden" name="token" value="{{ $token }}">

                <div class="form-group row col-12 mt-5">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <i class="far fa-envelope"></i>
                            </div>
                        </div>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>

                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row col-12">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <i class="fa fa-lock"></i>
                            </div>
                        </div>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row col-12">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <i class="fa fa-lock"></i>
                            </div>
                        </div>

                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                    </div>
                </div>

                <div class="form-group col-12 mt-5">
                    <button type="submit" class="password__btn btn d-block col-md-5 col-6">
                        リセット
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection