@extends('user.layouts.app_user')
@section('title','DogRUN')

@section('title', '新規会員登録')

@section('meta')
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('css/page/auth/register.css') }}">
@endsection

@section('content')

<div class="register register--add_information">
  <div class="register__inner">
    <div class="register__cont">

      <a class="register__logo" href="/">
        <img src="{{ asset('/images/icon.png') }}" alt="logo" width="100%">
      </a>

      <form clas="register__form" method="POST" action="{{ route('post_add_information')}}" enctype="multipart/form-data">
        {{ csrf_field() }}
        <p class="register__txt">
          「 DogRUN 」をご利用に当たり使用するニックネーム、自己紹介文等の登録です。必要事項を入力して確認画面へお進みください。
        </p>

        <div class="register__form-group">
          <label class="" for="name">ニックネーム</label>
          <div class="input-group mt-3 ">
            <input id="name" type="text"
              class="form-control @error('name') is-invalid @enderror form-control-sm" name="name" value="{{ old('name') }}" autocomplete="name" placeholder="ニックネームを記入">
          </div>
          @error('name')
          <span class="invalid-feedback d-block" role="alert">
            <strong>{{ $message }}</strong>
          </span>
          @enderror
        </div>

        <div class="register__form-group">
          <label for="intro">自己紹介文</label>
          <div class="input-group mt-3">
            <textarea id="intro" name="intro" class="form-control form-control-sm @error('intro') is-invalid @enderror" placeholder="自己紹介文を記入">{{ old('intro') }}</textarea>
          </div>
          @error('intro')
          <span class="invalid-feedback d-block" role="alert">
            <strong>{{ $message }}</strong>
          </span>
          @enderror
        </div>

        <div class="register__form-group">
          <label for="img_no">イメージ画像</label>

          <div class="input-group mt-3">

            <div class="dropdown">
              <div class="select">
                <span>イメージ画像選択</span>
                <i class="fa fa-chevron-left"></i>
              </div>
              <input type="hidden" name="img_no">
              <div class="dropdown-menu">
                <ul class="dropdown-menu-list">
                  <!-- <li id="1"><img src="{{ asset('\images\user\1.jpg') }}" alt="01"><b>female01</b></li>
                  <li id="2"><img src="{{ asset('\images\user\2.jpg') }}" alt="02"><b>male01</b></li>
                  <li id="3"><img src="{{ asset('\images\user\3.jpg') }}" alt="03"><b>male02</b></li>
                  <li id="4"><img src="{{ asset('\images\user\4.jpg') }}" alt="04"><b>male03</b></li>
                  <li id="5"><img src="{{ asset('\images\user\5.jpg') }}" alt="05"><b>female02</b></li>
                  <li id="6"><img src="{{ asset('\images\user\6.jpg') }}" alt="06"><b>female03</b></li>
                  <li id="7"><img src="{{ asset('\images\user\7.jpg') }}" alt="07"><b>female04</b></li>
                  <li id="8"><img src="{{ asset('\images\user\8.jpg') }}" alt="08"><b>female05</b></li>
                  <li id="9"><img src="{{ asset('\images\user\9.jpg') }}" alt="09"><b>female06</b></li>
                  <li id="10"><img src="{{ asset('\images\user\10.jpg') }}" alt="10"><b>male04</b></li>
                  <li id="11"><img src="{{ asset('\images\user\11.jpg') }}" alt="11"><b>male05</b></li>
                  <li id="12"><img src="{{ asset('\images\user\12.jpg') }}" alt="12"><b>female07</b></li>
                  <li id="13"><img src="{{ asset('\images\user\13.jpg') }}" alt="13"><b>male06</b></li> -->

                  <li id="toy_poodle"><img src="{{ asset('\images\dogs\toy_poodle.jpg') }}" alt="toy_poodle"><b>トイプードル</b></li>
                  <li id="shiba"><img src="{{ asset('\images\dogs\shiba.jpg') }}" alt="shiba"><b>柴犬</b></li>
                  <li id="chihuahua"><img src="{{ asset('\images\dogs\chihuahua.jpg') }}" alt="chihuahua"><b>チワワ</b></li>
                  <li id="miniature_dachshund"><img src="{{ asset('\images\dogs\miniature_dachshund.jpg') }}" alt="miniature_dachshund"><b>ミニチュアダックスフント</b></li>
                  <li id="pomeranian"><img src="{{ asset('\images\dogs\pomeranian.jpg') }}" alt="pomeranian"><b>ポメラニアン</b></li>
                  <li id="miniature_schnauzer"><img src="{{ asset('\images\dogs\miniature_schnauzer.jpg') }}" alt="miniature_schnauzer"><b>ミニチュアシュナウザー</b></li>
                  <li id="yorkshire_terrier"><img src="{{ asset('\images\dogs\yorkshire_terrier.jpg') }}" alt="yorkshire_terrier"><b>ヨークシャーテリア</b></li>
                  <li id="maltese"><img src="{{ asset('\images\dogs\maltese.jpg') }}" alt="maltese"><b>マルチーズ</b></li>
                  <li id="french_bulldog"><img src="{{ asset('\images\dogs\french_bulldog.jpg') }}" alt="french_bulldog"><b>フレンチブルドッグ</b></li>
                  <li id="papillon"><img src="{{ asset('\images\dogs\papillon.jpg') }}" alt="papillon"><b>パピヨン</b></li>
                  <li id="golden_retriever"><img src="{{ asset('\images\dogs\golden_retriever.jpg') }}" alt="golden_retriever"><b>ゴールデンレトリバー</b></li>
                  <li id="bichon_frise"><img src="{{ asset('\images\dogs\bichon_frise.jpg') }}" alt="bichon_frise"><b>ビションフリーゼ</b></li>
                  <li id="pug"><img src="{{ asset('\images\dogs\pug.jpg') }}" alt="pug"><b>パグ</b></li> 
                  <li id="mix(small-dog)"><img src="{{ asset('\images\dogs\mix(small-dog).jpg') }}" alt="mix(small-dog)"><b>ミックス（小型犬）</b></li> 
                  <li id="mix(medium-sizeddog)"><img src="{{ asset('\images\dogs\mix(medium-sizeddog).jpg') }}" alt="mix(medium-sizeddog)"><b>ミックス（中型犬）</b></li> 
                  <li id="mix(large-dog)"><img src="{{ asset('\images\dogs\mix(large-dog).jpg') }}" alt="mix(large-dog)"><b>ミックス（大型犬）</b></li> 
                </ul>
              </div>
            </div>

          </div>
        </div>

        <div class="w-100 mx-auto">
          <button type="submit" class="register__btn btn">完了</button>
        </div>

      </form>
    </div>

  </div>
</div>

@endsection