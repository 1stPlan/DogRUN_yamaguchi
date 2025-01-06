@extends('user.layouts.app_user')
@section('title','DogRUN | MYPAGE')

@section('meta')
@endsection

@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('css/page/user/setting/setting_edit.css') }}">
@endsection

@section('content')
<section class="setting-edit">
  <!-- Page content-->

  <div class="setting-edit__inner">
    <h3 class="setting-edit__title">MYPAGE</h3>
    <div class="setting-edit__cont">

      <form method="post" action="{{ url('/user/setting', $user->id) }}" enctype="multipart/form-data">
        {{ csrf_field() }}
        {{ method_field('patch') }}

        <table class="setting-edit__table">
          <tbody>
            <tr>
              <th>ニックネーム</th>
              <td><input class="form-control" type="text" name="name" value="{{ $user->name }}" autocomplete="name"></td>
            </tr>
            <tr>
              <th>メールアドレス</th>
              <td><input class="form-control" type="email" name="email" value="{{ $user->email }}" autocomplete="email"></td>
            </tr>
            <tr>
              <th>自己紹介</th>
              <td><textarea name="intro" class="form-control">{{ $user->intro }}</textarea></td>
            </tr>
            <tr>
              <th>イメージ画像</th>
              <td class="setting-edit__flex">

                <!-- @if($user->img_url)
                <div class="setting-edit__thumbnail">
                  <img id="icon_img_prv1" class="img_thumbnail" src="{{ asset( $user->img_url) }}" width="100%">
                </div>
                @endif
                <div class="setting-edit__file">
                  <input id="icon1" type="file" class="" accept="image/*" name="img_url" onchange="setImage">
                  <p class="small">※更新時のみ選択</p>
                </div> -->

                <div class="dropdown">
                  <div class="select">
                    <span>イメージ画像選択</span>
                    <i class="fa fa-chevron-left"></i>
                  </div>
                  <input type="hidden" name="img_no" value="{{ $user->img_no }}">
                  <div class="dropdown-menu">
                    <ul class="dropdown-menu-list">

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

              </td>
            </tr>
          </tbody>
        </table>

    </div>

    <div class="setting-edit__btn-box">
      <button type="submit" class="btn btn-primary">登録</button>
      <a href="{{ route('user.setting') }}" class="btn btn-secondary ml-2">キャンセル</a>
    </div>
    </form>
  </div>
  </div>
  </div>
</section>
@endsection

<!-- Datatables-->
@section('script')

<script>
  // アイコン画像プレビュー処理
  // 画像が選択される度に、この中の処理が走る

  $("#icon1").on("change", function(ev) {
    // このFileReaderが画像を読み込む上で大切
    const reader = new FileReader();
    // ファイル名を取得
    const fileName = ev.target.files[0].name;
    // 画像が読み込まれた時の動作を記述
    reader.onload = function(ev) {
      $("#icon_img_prv1").attr('src', ev.target.result).css('width', '150px').css('height', '150px');
    }
    reader.readAsDataURL(this.files[0]);
  })
</script>

@endsection