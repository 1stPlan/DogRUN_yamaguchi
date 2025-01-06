@extends('admin.layouts.app_admin')

@section('css')
<link rel="stylesheet" href="{{ asset('vendor/jquery-bootgrid/dist/jquery.bootgrid.css') }}">
{{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-footable/2.0.3/css/footable.core.css">
   <link href="{{ asset('css/admin/plugins/sweetalert/sweetalert.css') }}" rel="stylesheet"> --}}
@endsection

@section('js')
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-footable/2.0.3/js/footable.all.min.js"></script>
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script> --}}
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<!-- Page-Level Scripts -->
<script>
  var campaignTable = $('.footable').footable();

  $(document).on('click', '.delete', function() {
    var id = $(this).data('id');
    Swal.fire({
      title: "削除",
      text: "削除を実行してよろしいですか？",
      showCancelButton: true,
      confirmButtonText: "削除",

    }).then((result) => {
      if (result.isConfirmed) {
        Swal.fire("削除完了", "", "success");
        document.getElementById('eventParticipant_' + id).submit();
      }
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
      {{ $event->title }} 参加者一覧
    </div>

    <div class="wrapper wrapper-content animated fadeInRight">
      <div class="row">
        <div class="col-lg-12 mb-2">
          <a href="{{ route('admin.participant.create', $event->id) }}" class="btn btn-info btn-sm">新規作成</a>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-12">
          <div class="ibox float-e-margins">

            <div class="ibox-content">

              <input type="text" class="form-control input-sm m-b-xs" id="filter"
                placeholder="Search in table">

              <table class="footable table table-stripped toggle-arrow-tiny" data-filter="#filter">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>ニックネーム</th>
                    <th data-hide="all">email</th>
                    <th data-column-id="commands" data-formatter="commands" data-sortable="false" style="width: 10%">
                      <div class="text-right"></div>
                    </th>
                  </tr>
                </thead>
                <tbody>
                  @if (count($eventParticipants))
                  @foreach($eventParticipants as $index => $eventParticipant)

                  <form action="{{ route('admin.participant.destroy',$eventParticipant->id)  }}" id="eventParticipant_{{ $eventParticipant->id }}" method="POST">
                    @csrf
                    @method('DELETE')
                  </form>
                  <tr id="event_user_row{{ $eventParticipant->user_id }}">
                    <td>{{ $eventParticipant->user_id }}</td>
                    <td>{{ $eventParticipant->user()->first()->name }}</td>
                    <td>{{ $eventParticipant->user()->first()->email }}</td>
                    <td class="action">
                      <button class="btn btn-danger btn-sm delete" data-id="{{ $eventParticipant->id }}">削除</button>
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