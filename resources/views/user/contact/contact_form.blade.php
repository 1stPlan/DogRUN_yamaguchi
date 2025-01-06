@extends('user.layouts.app_user')
@section('title','DogRUN | CONTACT')

@section( 'css' )
<link rel="stylesheet" type="text/css" href="{{ asset('css/page/contact.css') }}">
@endsection

@section('content')

<section class="contact">

  <div class="contact__page_header">
    <h3 class="contact__page_title">管理者DM</h3>
  </div>

  <div class="contact__inner">

    <div class="contact__desc">
      <p>下記の必要項目を入力して送信してください。1 週間以内に、担当者より折り返しご連絡致します。
      </p>
    </div>

    <div class="contact__cont">
      <form action="{{ route('user.contact.send') }}" method="post">
        {{ csrf_field() }}
        <ul class="contact__list">

          <li class="contact__item">
            <p class="contact__item-tit">氏名</p>
            <div class="contact__item-flex">
              <div class="contact__item-wrap">
                <p class="contact__item-block"> {{ $inputs['name_top'] }}<input type="hidden" name="name_top" class="" size="60" value=" {{ $inputs['name_top'] }}" placeholder="お名前 姓"></p>
              </div>
              <div class="contact__item-wrap">
                <p class="contact__item-block"> {{ $inputs['name_bottom'] }}<input type="hidden" name="name_bottom" class="" size="60" value="{{ $inputs['name_bottom'] }}" placeholder="お名前 名"></p>
              </div>
            </div>
          </li>


          <li class="contact__item">
            <p class="contact__item-tit">メールアドレス</p>
            <p class="contact__item-block">{{ $inputs['mail'] }}<input type="hidden" name="mail" class="" size="60" value="{{ $inputs['mail'] }}" placeholder="半角で入力してください"></p>
          </li>

          <li class="contact__item">
            <p class="contact__item-tit">お問い合わせ内容</p>
            <p class="contact__item-block" style="white-space: pre-wrap;">{{ $inputs['content'] }}<textarea style="display:none;" class="" name="content" cols="30" rows="10" value="">{{ $inputs['content'] }}</textarea></p>
          </li>
        </ul>

        <div class="contact__button">
          <input type="submit" name="action" value="送信">
        </div>
        <div class="contact__button contact__button--2">
          <input type="submit" name="action" value="入力ページに戻る">
        </div>
      </form>

    </div>
  </div>

</section>

@endsection