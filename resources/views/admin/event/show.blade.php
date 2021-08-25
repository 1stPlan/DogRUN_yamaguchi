@extends('admin.layouts.app_admin')

@section('css')
<link rel="stylesheet" href="{{ asset('vendor/jquery-bootgrid/dist/jquery.bootgrid.css') }}">
@endsection

@section('js')
<script src="{{ asset('js/utility/toggle_form.js') }}"></script>
@endsection

@section('sidebar_first_level_active', 'event')

@section('sidebar_second_level_active', 'list')

@section('content')
<section class="section-container">
  <!-- Page content-->
  <div class="content-wrapper">
    <div class="content-heading">
      <div>イベント詳細</div>

      <div class="d-flex mr-5">
        <a href="{{ route('admin.events.edit', $event) }}" class="btn btn-info command-deletem ml-3"><em class="fa fa-edit fa-fw"></em></a>
      </div>

    </div>

    <div class="wrapper wrapper-content animated fadeInRight">
      <div class="card">
        <table class="table table-bordered table-striped" id="event" style="clear: both">
          <tbody>
            <tr>
              <td style="width: 35%">ID</td>
              <td style="width: 65%"><span>{{ $event['id'] }}</span></td>
            </tr>

            <tr>
              <td>タイトル</td>
              <td><span>{{ $event->title }}</span></td>
            </tr>

            <tr>
              <td>画像</td>
              <td><span>
                  <img src="{{ asset('storage/image/event/'. $event->img_url.'.jpg') }}" alt="" width="50%">
                </span>
              </td>
            </tr>

            <tr>
              <td>開催日時</td>
              <td><span>{{ $event->start_datetime->format('Y年m月d日 H時i分') }}</span></td>
            </tr>

            <tr>
              <td>開催内容</td>
              <td><span> {!! nl2br($event->body) !!}</span></td>
            </tr>
            <tr>
              <td>開催場所</td>
              <td><span>{{ $event->venue  }}</span></td>
            </tr>

            <tr>
              <td>チケット代（税抜）</td>
              <td><span>{{ $event->ticket_price  }}</span></td>
            </tr>
            <tr>
              <th>補足</th>
              <td><span>{!! nl2br($event->remarks) !!}</span></td>
            </tr>

            <tr>
              <td>参加者への特記事項</td>
              <td><span>{!! nl2br($event->remarks) !!}</span></td>
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