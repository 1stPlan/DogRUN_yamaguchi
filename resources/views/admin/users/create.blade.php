@extends('admin.layouts.app_admin')

@section('css')
   <link rel="stylesheet" href="{{ asset('vendor/jquery-bootgrid/dist/jquery.bootgrid.css') }}">
 <style>
   .bank{
     display: none;
   }
   .show{
     display: table-cell!important;
   }
   .hide{
     display: none!important;
   }
 </style>

@endsection

@section('content')
  <section class="section-container">
     <!-- Page content-->
     <div class="content-wrapper">
        <div class="content-heading">
           {{-- <div>Data Tables<small>Tables, one step forward.</small></div> --}}
           ユーザー新規登録
        </div>
        <!-- START card-->
        {{-- <div class="card card-default">
           <div class="card-header font-weight-bold" style="font-size:16px;">ユーザー新規登録</div>
           <div class="card-body"> --}}

           <div class="card p-2 w-50">
              <div class="font-weight-bold">title：ID_ユーザー名</div>
           </div><!-- END card-->

              <form>
                <div class="card card-default mb-1">
                  <div class="card-header font-weight-bold" style="font-size:16px;">基本情報</div>
                  <div class="card-body border-top">
                    <table class="table table-bordered table-striped mt-3" id="user" style="clear: both">
                      <tbody>
                         <tr>
                            <th style="width: 25%">氏名</th>
                            <td style="width: 75%"><input class="form-control" type="text" name="name" placeholder="山田 二郎" autocomplete="name"></td>
                         </tr>
                         <tr>
                            <th>フリガナ</th>
                            <td><input class="form-control" type="text" name="name" placeholder="ヤマダ ジロウ" autocomplete="name"></td>
                         </tr>
                         <tr>
                            <th>メールアドレス</th>
                            <td><input class="form-control" type="text" name="mail" placeholder="60"></td>
                         </tr>
                         <tr>
                            <th>タイプ</th>
                            <td><input class="form-control" type="text" name="type" placeholder="A"></td>
                         </tr>

                      </tbody>
                    </table>
                  </div>
                </div>

                <div class="d-flex align-items-center justify-content-end">
                  <button type="submit" name="button" class="btn btn-info">保存</button>
                  <button type="submit" name="button" class="btn btn-light text-dark ml-3 border">キャンセル</button>
              </div>
              </form>
            {{-- </div>
         </div><!-- END card-->
      </div> --}}
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
