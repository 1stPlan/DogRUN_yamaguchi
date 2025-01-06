@extends('admin.layouts.app_admin')

@section('css')
<link rel="stylesheet" href="{{ asset('vendor/jquery-bootgrid/dist/jquery.bootgrid.css') }}">

@endsection

@section('js')
<script src="{{ asset('js/admin/plugins/footable/footable.all.min.js') }}"></script>

<!-- Page-Level Scripts -->
<script>
  $(document).ready(function() {
    $('.footable').footable();
  });
</script>

@endsection

@section('content')
<section class="section-container">
  <!-- Page content-->
  <div class="content-wrapper">
    <div class="content-heading">
      イベント作成
    </div>


    <div class="wrapper wrapper-content animated fadeInRight">

      <div class="row">
        <div class="col-lg-12">
          <div class="ibox float-e-margins">
            <div class="ibox-title">
            </div>
            <div class="ibox-content">
              <div>
                @if ($errors->all())
                @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
                @endforeach
                @endif
              </div>
              <form action="{{ route('admin.events.store') }}" method="post" class="form-horizontal" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="form-group mb-4">
                  <label class="col-sm-5 control-label">タイトル</label>
                  <div class="hr-line-dashed col-sm-10 mt-1 mb-3"></div>
                  <div class="col-sm-10"><input name="title" type="text" class="form-control" value="{{ old('title') }}"></div>
                </div>

                <div class="form-group my-4">
                  <label class="col-sm-5 control-label">開催日時</label>
                  <div class="hr-line-dashed col-sm-10 mt-1 mb-3"></div>

                  <div class="col-sm-10">
                    <div class="input-group date align-items-center">
                      <span class="input-group-addon"><i class="fa fa-calendar col-sm-2"></i></span><input name="start_datetime" type="datetime" class="form-control date_picker" autocomplete="off" value="{{ old('start_datetime') }}">
                    </div>
                  </div>
                </div>

                <div class="form-group mb-4">
                  <label class="col-sm-5 control-label">開催場所</label>
                  <div class="hr-line-dashed col-sm-10 mt-1 mb-3"></div>
                  <div class="col-sm-10"><input name="venue" type="text" class="form-control" value="{{ old('venue') }}"></div>
                </div>

                <div class="form-group mb-4">
                  <label class="col-sm-5 control-label">料金</label>
                  <div class="hr-line-dashed col-sm-10 mt-1 mb-3"></div>
                  <div class="col-sm-10"><input name="ticket_price" type="text" class="form-control" value="{{ old('ticket_price') }}"></div>
                </div>


                <div class="form-group my-4">
                  <label class="col-sm-5 control-label">説明</label>
                  <div class="hr-line-dashed col-sm-10 mt-1 mb-3"></div>

                  <div class="col-sm-10"><textarea rows="10" name="body" class="form-control">{{ old('body') }}</textarea></div>
                </div>

                <div class="form-group my-4">
                  <label class="col-sm-5 control-label">参加者への特記事項</label>
                  <div class="hr-line-dashed col-sm-10 mt-1 mb-3"></div>

                  <div class="col-sm-10"><textarea name="remarks" class="form-control">{{ old('remarks') }}</textarea></div>
                </div>

                <div class="form-group my-4">
                  <label class="col-sm-5 control-label">画像</label>
                  <div class="hr-line-dashed col-sm-10 mt-1 mb-3"></div>

                  <input class="col-sm-10" id="icon3" type="file" class="mt-2" name="img_url">
                  <div class="thumbnail">
                    <img id="icon_img_prv3" src="{{ asset('/images/dummy.png') }}" width="100%">
                  </div>
                </div>

                <div class="form-group mb-1">
                  <label class="col-sm-5 control-label">ショップイベント</label>
                  <div class="hr-line-dashed col-sm-10 mt-1 mb-3"></div>

                  <div class="col-sm-10">
                    <label><input type="radio" name="maker" value="1" onclick="formSwitch()" checked>なし</label>
                    <label><input type="radio" name="maker" value="2" onclick="formSwitch()">あり</label>
                  </div>
                </div>


                <div id="shopList" class="flex-wrap p-3 bg-secondary gap-2">
                  @foreach ($places as $place)
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="{{ $place->id }}" name="places">
                    <label class="form-check-label">{{ $place->name }}</label>
                  </div>
                  @endforeach

                </div>

                <div class="form-group mt-5">
                  <div class="col-sm-4 col-sm-offset-2 mx-auto">
                    <a class="btn btn-white" href="{{ route('admin.events.index') }}">戻る</a>
                    <button class="btn btn-primary" type="submit">登録する</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
</section>
@endsection


<!-- Datatables-->
@section('footer_js')

<script>
  // アイコン画像プレビュー処理
  // 画像が選択される度に、この中の処理が走る

  $("#icon3").on("change", function(ev) {
    // このFileReaderが画像を読み込む上で大切
    const reader = new FileReader();
    // ファイル名を取得
    const fileName = ev.target.files[0].name;
    // 画像が読み込まれた時の動作を記述
    reader.onload = function(ev) {
      $("#icon_img_prv3").attr('src', ev.target.result).css('width', '150px').css('height', '150px');
    }
    reader.readAsDataURL(this.files[0]);
  })
</script>

<script src="{{ asset('vendor/jquery-sparkline/jquery.sparkline.js') }}"></script>
<script src="{{ asset('vendor/flot/jquery.flot.js') }}"></script>
<script src="{{ asset('vendor/jquery.flot.tooltip/js/jquery.flot.tooltip.js') }}"></script>
<script src="{{ asset('vendor/flot/jquery.flot.resize.js') }}"></script>
<script src="{{ asset('vendor/flot/jquery.flot.pie.js') }}"></script>
<script src="{{ asset('vendor/flot/jquery.flot.time.js') }}"></script>
<script src="{{ asset('vendor/flot/jquery.flot.categories.js') }}"></script>
<script src="{{ asset('vendor/jquery.flot.spline/jquery.flot.spline.js') }}"></script>
<script src="{{ asset('vendor/jquery-slimscroll/jquery.slimscroll.js') }}"></script>

<script>
  function formSwitch() {
    let marker = document.getElementsByName('maker')

    if (marker[0].checked) {
      // いいえが選択されると下記を実行します。

      document.getElementById('shopList').style.display = "none";
      var inputItem = document.getElementById("shopList").getElementsByTagName("input");
      for (var i = 0; i < inputItem.length; i++) {
        inputItem[i].checked = "";
      }
    } else if (marker[1].checked) {
      // はいが選択されたら下記を実行します。

      document.getElementById('shopList').style.display = "flex";

      const inputClass = document.getElementsByClassName("form-check-input");
      for (let i = 0; i < inputClass.length; i++) {
        inputClass[i].onclick = function() {
          for (let u = 0; u < inputClass.length; u++) {
            inputClass[u].checked = false;
            this.checked = true;
          }
        }
      }
    }
  }
  window.addEventListener('load', formSwitch());
</script>


@endsection