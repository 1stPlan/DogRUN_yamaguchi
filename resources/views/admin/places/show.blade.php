@extends('admin.layouts.app_admin')

@section('css')
<link rel="stylesheet" href="{{ asset('vendor/jquery-bootgrid/dist/jquery.bootgrid.css') }}">
@endsection

@section('js')
<script src="{{ asset('js/utility/toggle_form.js') }}"></script>
@endsection

@section('sidebar_first_level_active', 'place')

@section('sidebar_second_level_active', 'list')

@section('content')
<section class="section-container">
  <!-- Page content-->
  <div class="content-wrapper">
    <div class="content-heading">
      <div>ショップ詳細</div>

      <div class="d-flex mr-5">
        <a href="{{ route('admin.places.edit', $place) }}" class="btn btn-info command-deletem ml-3"><em class="fa fa-edit fa-fw"></em></a>
        <a href="#" class="btn  btn-warning command-deletem ml-3" onclick="deleteUser(this);" data-id="place_id"><em class="fa fa-trash fa-fw"></em></a> <!-- thisは戻り値として -->
      </div>
    </div>

    <form action="{{ route('admin.places.destroy', $place) }}" id="place_{{ $place->id }}" method="POST">
      @csrf
      @method('DELETE')
    </form>

    <div class="wrapper wrapper-content animated fadeInRight">
      <div class="card">
        <table class="table table-bordered table-striped" id="place" style="clear: both">
          <tbody>
            <tr>
              <td style="width: 35%">ID</td>
              <td style="width: 65%"><span>{{ $place['id'] }}</span></td>
            </tr>

            <tr>
              <td>名前</td>
              <td><span>{{ $place['name'] }}</span></td>
            </tr>

            <tr>
              <td>住所</td>
              <td><span>{{ $place['address'] }}</span></td>
            </tr>

            <tr>
              <td>値段</td>
              <td><span>{{ $place['price'] }}</span></td>
            </tr>

            <tr>
              <td>営業時間</td>
              <td><span>{{ $place['time'] }}</span></td>
            </tr>

            <tr>
              <td>お休み</td>
              <td><span>{{ $place['off'] }}</span></td>
            </tr>

            <tr>
              <td>URL</td>
              <td><span>{{ $place['url'] }}</span></td>
            </tr>

            <tr>
              <td>画像</td>
              <td><span>
                  <img src="{{ asset('/images/shop/'. $place['data_id'] .'.jpg') }}" alt="" width="50%">
                </span>
              </td>
            </tr>

            <tr>
              <td>サービス</td>
              <td>
                <ul>
                  <li><span>CAFE</span> : <?php echo $place['service_1']  ? "あり" : "無" ?></li>
                  <li><span>INDOOR</span> : <?php echo $place['service_2']  ? "あり" : "無" ?></li>
                  <li><span>KASIKIRI</span> : <?php echo $place['service_3']  ? "あり" : "無" ?></li>
                </ul>
              </td>
            </tr>

          </tbody>
        </table>

      </div>
    </div>
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