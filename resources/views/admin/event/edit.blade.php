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
      <div>イベント編集</div>
    </div>

    <div class="wrapper wrapper-content animated fadeInRight">
      <!-- START card-->
      <div class="card p-2 w-50">
        <div class="font-weight-bold">Event ID: {{ $event->id }}</div>
      </div><!-- END card-->

      <form action="{{ route('admin.events.update', ['event' => $event->id]) }}" method="post" class="form-horizontal" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <div class="card card-default mb-1">
          <div class="card-header font-weight-bold" style="font-size:16px;">イベント情報</div>
          <div class="card-body border-top">
            <table class="table table-bordered table-striped mt-3" id="user" style="clear: both">
              <tbody>
                <tr>
                  <th style="width: 25%">タイトル</th>
                  <td style="width: 75%">
                    <input class="form-control" type="text" name="title" value="{{ old('title', $event->title) }}" autocomplete="">
                  </td>
                </tr>

                <tr>
                  <th>開催日時</th>
                  <td>
                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input name="start_datetime" type="datetime" class="form-control date_picker" value="{{ old('start_datetime', $event->start_datetime) }}">
                  </td>
                </tr>

                <tr>
                  <th>開催場所</th>
                  <td>
                    <input name="venue" type="text" class="form-control" value="{{ old('venue', $event->venue) }}">
                  </td>
                </tr>

                <tr>
                  <th>料金</th>
                  <td>
                    <input name="venue" type="text" class="form-control" value="{{ old('venue', $event->venue) }}">
                  </td>
                </tr>

                <tr>
                  <th>説明</th>
                  <td>
                    <textarea rows="10" name="body" class="form-control">{{ old('body', $event->body) }}</textarea>
                  </td>
                </tr>

                <tr>
                  <th>参加者への特記事項</th>
                  <td>
                    <textarea rows="10" name="remarks" class="form-control">{{ old('remarks', $event->remarks) }}</textarea>
                  </td>
                </tr>

                <tr>
                  <th>画像</th>
                  <td>
                    <input class="col-sm-10" id="icon2" type="file" class="mt-2" name="img_url"  value="{{ old('img_url', $event->img_url) }}">
                    <div class="thumbnail">
                      <img id="icon_img_prv2" src="{{ asset('storage/image/event/'. $event->img_url.'.jpg') }}" width="100%">
                    </div>
                  </td>
                </tr>

                <tr>
                  <th>ショップイベント</th>
                  <td>
                    <label><input type="radio" name="maker" value="1" onclick="formSwitch()" checked>なし</label>
                    <label><input type="radio" name="maker" value="2" onclick="formSwitch()">あり</label>
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

  $("#icon2").on("change", function(ev) {
    // このFileReaderが画像を読み込む上で大切
    const reader = new FileReader();
    // ファイル名を取得
    const fileName = ev.target.files[0].name;
    // 画像が読み込まれた時の動作を記述
    reader.onload = function(ev) {
      $("#icon_img_prv2").attr('src', ev.target.result).css('width', '150px').css('height', '150px');
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