@extends('admin.layouts.app_admin')

@section('css')
   <link rel="stylesheet" href="{{ asset('vendor/jquery-bootgrid/dist/jquery.bootgrid.css') }}">
   {{-- <link href="{{ asset('css/admin/plugins/footable/footable.core.css') }}" rel="stylesheet">
   <link href="{{ asset('css/admin/plugins/sweetalert/sweetalert.css') }}" rel="stylesheet"> --}}
@endsection

@section('js')
  {{-- <script src="{{ asset('js/admin/plugins/footable/footable.all.min.js') }}"></script> --}}

  <!-- Page-Level Scripts -->
  <script>
      $(document).ready(function() {
          $('.footable').footable();
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
      <div class="col-lg-12">
        <div class="ibox float-e-margins">
          <div class="ibox-title">
            {{--<h5>Basic Table</h5>--}}
          </div>
          <div class="ibox-content">
            <div>
              @if ($errors->all())
                @foreach($errors->all() as $error)
                  <p>{{ $error }}</p>
                @endforeach
              @endif
            </div>
            <form action="{{ route('admin.participant.store') }}" method="post" class="form-horizontal">
              {{ csrf_field() }}
              <input name="event_id" type="hidden" value="{{ $event->id }}">
              <p>ユーザーidかメールアドレスのどちらかを入力してください。</p>
              <div class="hr-line-dashed col-sm-10 mt-1 mb-3"></div>
              <div class="form-group">
                <label class="col-sm-5 control-label">ユーザーid</label>
                
                <div class="col-sm-10"><input name="user_id" type="text" class="form-control" value="{{ old('user_id') }}"></div>
              </div>
             
              <div class="form-group">
                <label class="col-sm-5 control-label">メールアドレス</label>

                <div class="col-sm-10"><input name="email" type="text" class="form-control" value="{{ old('email') }}"></div>
              </div>
            
              <div class="form-group">
                <div class="col-sm-4 col-sm-offset-2">
                  <a class="btn btn-white" href="">戻る</a>
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
