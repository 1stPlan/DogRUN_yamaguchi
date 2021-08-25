@extends('admin.layouts.app_admin')

@section('css')
<link href="{{ asset('css/admin/plugins/footable.core.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('vendor/jquery-bootgrid/dist/jquery.bootgrid.css') }}">
@endsection

@section('js')

<script src="{{ asset('js/admin/plugins/footable.all.min.js') }}"></script>
<script src="{{ asset('js/admin/plugins/sweetalert.min.js') }}"></script>
@endsection

@section('sidebar_first_level_active', 'event')

@section('sidebar_second_level_active', 'list')

@section('content')
<section class="section-container">
  <!-- Page content-->
  <div class="content-wrapper">
    <div class="content-heading">
      <div>ショップ作成</div>
    </div>

    <div class="wrapper wrapper-content animated fadeInRight">

      <form action="{{ route('admin.events.store') }}" method="post" class="form-horizontal" enctype="multipart/form-data">
        {{ csrf_field() }}

        <div class="card card-default mb-1">
          <div class="card-heDader font-weight-bold" style="font-size:16px;">ショップ情報</div>
          <div class="card-body border-top">
            <table class="table table-bordered table-striped mt-3" id="user" style="clear: both">
              <tbody>
                <tr>
                  <th style="width: 25%">名前</th>
                  <td style="width: 75%">
                    <input class="form-control" type="text" name="name" value="" autocomplete="">
                  </td>
                </tr>
                <tr>
                  <th>住所</th>
                  <td>
                    <input class="form-control" type="text" name="address" value="" autocomplete="">
                  </td>
                </tr>
                <tr>
                  <th>値段</th>
                  <td>
                    <input class="form-control" type="text" name="price" value="" autocomplete="">
                  </td>
                </tr>
                <tr>
                  <th>営業時間</th>
                  <td>
                    <input class="form-control" type="text" name="time" value="" autocomplete="">
                  </td>
                </tr>
                <tr>
                  <th>お休み</th>
                  <td>
                    <input class="form-control" type="text" name="off" value="" autocomplete="">
                  </td>
                </tr>
                <tr>
                  <td>URL</td>
                  <td>
                    <input class="form-control" type="text" name="url" value="" autocomplete="">
                  </td>
                </tr>

                <tr>
                  <th>画像</th>
                  <td>
                    <input class="col-sm-10" id="icon4" type="file" class="mt-2" name="img_url">
                    <div class="thumbnail">
                      <img id="icon_img_prv4" src="{{ asset('/images/dummy.png') }}" width="100%">
                  </td>
                </tr>



                <tr>
                  <td>サービス</td>
                  <td>
                    <ul>
                      <li><span>CAFE</span> : <input type="checkbox" name="CAFE" value=""></li>
                      <li><span>INDOOR</span> : <input type="checkbox" name="INDOOR" value=""></li>
                      <li><span>KASIKIRI</span> : <input type="checkbox" name="KASIKIRI" value=""></li>
                    </ul>
                  </td>
                </tr>

              </tbody>
            </table>

            <div class="form-group">
              <div class="col-sm-4 col-sm-offset-2">
                <a class="btn btn-white" href="{{ route('admin.events.index') }}">戻る</a>
                <button class="btn btn-primary" type="submit">登録する</button>
              </div>
            </div>

          </div>
        </div>
      </form>
    </div>
  </div>
</section>


@endsection


<!-- Datatables-->
@section('footer_js')

<script>
  // アイコン画像プレビュー処理
  // 画像が選択される度に、この中の処理が走る

  $("#icon4").on("change", function(ev) {
    // このFileReaderが画像を読み込む上で大切
    const reader = new FileReader();
    // ファイル名を取得
    const fileName = ev.target.files[0].name;
    // 画像が読み込まれた時の動作を記述
    reader.onload = function(ev) {
      $("#icon_img_prv4").attr('src', ev.target.result).css('width', '150px').css('height', '150px');
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
@endsection