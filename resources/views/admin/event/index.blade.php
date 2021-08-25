@extends('admin.layouts.app_admin')

@section('css')
   <link rel="stylesheet" href="{{ asset('vendor/jquery-bootgrid/dist/jquery.bootgrid.css') }}">
   <link href="{{ asset('css/admin/plugins/footable.core.css') }}" rel="stylesheet">
@endsection

@section('sidebar_first_level_active', 'user_event')

@section('js')
  <!-- Page-Level Scripts -->
  <script>
  $(document).ready(function() {

      var campaignTable = $('.footable').footable();

      $(document).on('click', '.delete', function () {
            var id = $(this).data('id');
            Swal.fire({
              title: "イベント削除",
              text: "イベント削除を実行してよろしいですか？",
              showCancelButton: true,
              confirmButtonText: "削除",

            }).then((result) => {
              if (result.isConfirmed) {
                Swal.fire("削除完了", "", "success");
                document.getElementById('event_'+ id).submit();
              } 
            });
      });

  });
  </script>
@endsection

@section('sidebar_first_level_active', 'event')

@section('sidebar_second_level_active', 'list')

@section('content')
<section class="section-container">
  <!-- Page content-->
  <div class="content-wrapper">
     <div class="content-heading">
        イベント一覧
     </div>


  <div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
      <div class="col-lg-12">
        <div class="ibox float-e-margins">
          <div class="ibox-title">
            <h5>イベント検索</h5>
          </div>
          <div class="ibox-content">
            <input type="text" class="form-control input-sm m-b-xs" id="filter" placeholder="Search in table">
            <table class="footable table table-stripped toggle-arrow-tiny" data-filter="#filter">
              <thead>
              <tr>
                <th data-toggle="true">イベントID</th>
                <th data-toggle="true">タイトル</th>
                <th data-toggle="true">開催日時</th>

                <th data-column-id="commands" data-formatter="commands" data-sortable="false">
                  <div class=""></div>
                </th>
                <th data-column-id="commands" data-formatter="commands" data-sortable="false">
                  <div class=""></div>
                </th>
                <th data-column-id="commands" data-formatter="commands" data-sortable="false">
                  <div class=""></div>
                </th>
                <th data-column-id="commands" data-formatter="commands" data-sortable="false">
                  <div class=""></div>
                </th>
                <th data-column-id="commands" data-formatter="commands" data-sortable="false">
                  <div class=""></div>
                </th>
              </tr>
              </thead>
              <tbody>


                @if (count($eventInfo))

                  @foreach($eventInfo as $index => $event)

                  <form action="{{ route('admin.events.destroy', $event['id']) }}" id="event_{{ $event['id'] }}" method="POST">
                    @csrf
                    @method('DELETE')
                  </form>

                  <tr id="event_row{{ $event['id'] }}">
                    <td>{{ $event['id'] }}</td>
                    <td>{{ $event['title'] }}</td>
                    <td>{{ $event['start_datetime'] }}</td>

                    <td>
                      <a href="{{ route('admin.events.show', $event['id']) }}" class="btn btn-info btn-sm command-deletem">詳細</a>
                    </td>
                    <td>
                      <a href="{{ route('admin.events.edit', $event['id']) }}" class="btn btn-info btn-sm command-deletem">編集</a>
                    </td>
                    <td>
                      <button class="btn btn-danger btn-sm delete" data-id="{{ $event['id'] }}">削除</button>
                    </td>
                    <td>
                      <a href="{{ route('admin.participant.index', $event['id']) }}" class="btn btn-primary btn-sm">参加者一覧</a>
                    </td>
                    <td>
                      <a href="{{ route('admin.post.index', $event['id']) }}" class="btn btn-primary btn-sm">投稿一覧</a>
                    </td>
                  </tr>
                  @endforeach

                @endif
              </tbody>
              <tfoot>
              <tr>
                <td colspan="12">
                  <ul class="pagination pull-right"></ul>
                </td>
              </tr>
              </tfoot>
            </table>

          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</section>

@endsection

   <!-- Datatables-->
@section('footer_js')
  <script src="{{ asset('vendor/jquery-bootgrid/dist/jquery.bootgrid.js') }}"></script>
  <script src="{{ asset('vendor/jquery-bootgrid/dist/jquery.bootgrid.fa.js') }}"></script>
  <script src="{{ asset('js/admin/button.js') }}"></script>
@endsection
