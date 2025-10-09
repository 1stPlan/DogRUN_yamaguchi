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
      <p>下記の必要項目を入力して送信してください。1 週間以内に、担当者より折り返しご連絡致します。<br>
        <span class="contact__color-red">*</span> の項目は必須項目です。
      </p>
    </div>

    <div class="contact__cont">
      <form action="{{ route('user.contact.form') }}" method="post">
        {{ csrf_field() }}
        <ul class="contact__list">

          <li class="contact__item">
            <p class="contact__item-tit">
              氏名<span class="contact__color-red">*</span>
            </p>
            <div class="contact__item-flex">
              <div class="contact__item-wrap">
                <p class="contact__item-block">
                  <input type="text" name="name_top" class="" size="60" value="{{ old('name_top') }}" placeholder="姓">
                </p>
                @if($errors->has('name_top'))
                <span class="contact__error contact__color-red">{{ $errors->first('name_top') }}</span>
                @endif
              </div>
              <div class="contact__item-wrap">
                <p class="contact__item-block">
                  <input type="text" name="name_bottom" class="" size="60" value="{{ old('name_bottom') }}" placeholder="名">
                </p>
                @if($errors->has('name_bottom'))
                <span class="contact__error contact__color-red">{{ $errors->first('name_bottom') }}</span>
                @endif
              </div>
            </div>
          </li>

          <li class="contact__item">
            <p class="contact__item-tit">メールアドレス<span class="contact__color-red">*</span></p>
            <p class="contact__item-block"><input type="email" name="mail" class="" size="60" value="{{ old('mail') }}" placeholder="半角で入力してください"></p>
            @if($errors->has('mail'))
            <span class="contact__error contact__color-red">{{ $errors->first('mail') }}</span>
            @endif
          </li>


          <li class="contact__item">
            <p class="contact__item-tit">お問い合わせ内容 <span class="contact__color-red">*</span></p>
            <p class="contact__item-block"><textarea class="" name="content" cols="30" rows="5">{{ old('content') }}</textarea></p>
            @if($errors->has('content'))
            <span class="contact__error contact__color-red">{{ $errors->first('content') }}</span>
            @endif
          </li>
        </ul>


        <div class="contact__text_about">
          <h5>■個人情報の利用目的について</h5>
          <p>本お問い合わせフォームで収集した個人情報は、お問い合わせへの回答のみに利用します。</p>
        </div>


        <div class="contact__button">
          <input type="submit" value="同意して内容を確認する">
        </div>

      </form>

      <div class="contact__back-button">
        <a href="{{ route('top') }}" class="">戻る</a>
      </div>

    </div>


  </div>

</section>

@endsection