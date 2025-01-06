@extends('admin.layouts.app_admin')

@section('css')
<link rel="stylesheet" href="{{ asset('vendor/jquery-bootgrid/dist/jquery.bootgrid.css') }}">

<style>
   ul {
      list-style: none;
   }

   .dropdown_2 {
      width: 300px;
      display: inline-block;
      background-color: #fff;
      border-radius: 2px;
      box-shadow: 0 0 2px #cccccc;
      transition: all 0.5s ease;
      position: relative;
      font-size: 14px;
      color: #474747;
      height: 100%;
      text-align: left;
   }

   .dropdown_2 .select {
      cursor: pointer;
      display: block;
      padding: 10px;
   }

   .dropdown_2 .select>i {
      font-size: 13px;
      color: #888;
      cursor: pointer;
      transition: all 0.3s ease-in-out;
      float: right;
      line-height: 20px;
   }

   .dropdown_2:hover {
      box-shadow: 0 0 4px #cccccc;
   }

   .dropdown_2:active {
      background-color: #f8f8f8;
   }

   .dropdown_2.active:hover,
   .dropdown_2.active {
      box-shadow: 0 0 4px #cccccc;
      border-radius: 2px 2px 0 0;
      background-color: #f8f8f8;
   }

   .dropdown_2.active .select>i {
      transform: rotate(-90deg);
   }

   .dropdown_2 .dropdown_2-menu {
      position: absolute;
      background-color: #fff;
      width: 125%;
      left: 0;
      margin-top: 1px;
      box-shadow: 0 1px 2px #cccccc;
      border-radius: 0 1px 2px 2px;
      overflow: hidden;
      max-height: 144px;
      overflow-x: auto;
      z-index: 9;
      padding: 0;
      list-style: none;
      display: none;
   }

   .dropdown_2 .dropdown_2-menu-list {
      display: flex;
   }

   .dropdown_2 .dropdown_2-menu li {
      padding: 10px;
      transition: all 0.2s ease-in-out;
      cursor: pointer;
   }

   .dropdown_2 .dropdown_2-menu img {
      width: 5rem;
   }

   .dropdown_2 .dropdown_2-menu b {
      display: block;
      font-size: 10px;
   }

   .dropdown_2 .dropdown_2-menu li:hover {
      background-color: #f2f2f2;
   }

   .dropdown_2 .dropdown_2-menu li:active {
      background-color: #e2e2e2;
   }
</style>

@endsection

@section('content')
<section class="section-container">
   <!-- Page content-->
   <div class="content-wrapper">
      <div class="content-heading">
         ユーザー基本情報編集
      </div>
      <!-- START card-->
      <div class="card p-2 w-50">
         <div class="font-weight-bold">User ID: {{ $user->id }}</div>
      </div><!-- END card-->

      <form action="{{ url('/admin/user', $user) }}" method="post" class="form-horizontal" enctype="multipart/form-data">

         {{ csrf_field() }}
         {{ method_field('patch') }}

         <div class="card card-default mb-1">
            <div class="card-header font-weight-bold" style="font-size:16px;">基本情報</div>
            <div class="card-body border-top">
               <table class="table table-bordered table-striped mt-3" id="user" style="clear: both">
                  <tbody>
                     <tr>
                        <th style="width: 25%">名前</th>
                        <td style="width: 75%"><input class="form-control" type="text" name="name" value="{{ old('name', $user->name) }}" autocomplete="name"></td>
                     </tr>
                     <tr>
                        <th>メールアドレス</th>
                        <td><input class="form-control" type="text" name="mail" value="{{ old('name', $user->email) }}"></td>
                     </tr>
                     <tr>
                        <th>自己紹介</th>
                        <td><textarea name="intro" class="form-control" rows="5">{{ old('name', $user->intro) }}</textarea></td>
                     </tr>

                     <tr>
                        <th>イメージ画像</th>
                        <td>
                           <div class="dropdown_2">
                              <div class="select">
                                 <span>イメージ画像選択</span>
                                 <i class="fa fa-chevron-left"></i>
                              </div>
                              <input type="hidden" name="img_no" value="{{ $user->img_no }}">
                              <div class="dropdown_2-menu">
                                 <ul class="dropdown_2-menu-list">

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
         </div>

         <div class="d-flex align-items-center justify-content-center mt-4">
            <a class="btn btn-info mr-2" href="{{ route('admin.users.index') }}">戻る</a>
            <button type="submit" name="button" class="btn btn-info">保存</button>
         </div>
      </form>

   </div>
</section>
@endsection


<!-- Datatables-->
@section('footer_js')
<script src="{{ asset('vendor/jquery-sparkline/jquery.sparkline.js') }}"></script>
<script src="{{ asset('vendor/flot/jquery.flot.js') }}"></script>
<script src="{{ asset('vendor/jquery.flot.tooltip/js/jquery.flot.tooltip.js') }}"></script>
<script src="{{ asset('vendor/flot/jquery.flot.resize.js') }}"></script>
<script src="{{ asset('vendor/flot/jquery.flot.pie.js') }}"></script>
<script src="{{ asset('vendor/flot/jquery.flot.time.js') }}"></script>
<script src="{{ asset('vendor/flot/jquery.flot.categories.js') }}"></script>
<script src="{{ asset('vendor/jquery.flot.spline/jquery.flot.spline.js') }}"></script>
<script src="{{ asset('vendor/jquery-slimscroll/jquery.slimscroll.js') }}"></script>
@endsection