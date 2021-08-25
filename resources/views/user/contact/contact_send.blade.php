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
      <p>お問い合わせ内容を受け付けました。
        1週間以内に、担当者より折り返しご連絡致します。</p>
    </div>

    <div class="contact__button contact__button--3">
      <a class="" href="{{ route('user.place') }}">PAGE TOP</a>
    </div>
  </div>

</section>


@endsection