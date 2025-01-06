@extends('admin.layouts.app_admin')

@section('css')
<link rel="stylesheet" href="{{ asset('vendor/jquery-bootgrid/dist/jquery.bootgrid.css') }}">
@endsection

@section('sidebar_first_level_active', 'user_index')

@section('content')
<section class="section-container">
   <!-- Page content-->
   <div class="content-wrapper">
      <div class="content-heading">

         <div class="d-flex align-items-center justify-content-between">
            <div>ユーザー情報詳細</div>

            <div class="d-flex mr-5">
               <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-info command-deletem ml-3"><em class="fa fa-edit fa-fw"></em></a>
               <a href="#" class="btn  btn-warning command-deletem ml-3" onclick="deleteUser(this);" data-id="user_id"><em class="fa fa-trash fa-fw"></em></a> <!-- thisは戻り値として -->
            </div>
         </div>
      </div>
      <div class="container-fluid">
         <!-- DATATABLE DEMO 1-->

         <div class="card">
            <form action="{{ route('admin.users.destroy', $user) }}" id="user_{{ $user->id }}" method="POST">
               @csrf
               @method('DELETE')
            </form>
            <table class="table table-bordered table-striped" id="user" style="clear: both">
               <tbody>
                  <tr>
                     <td style="width: 35%">会員ID</td>
                     <td style="width: 65%"><span>{{ $user['id'] }}</span></td>
                  </tr>
                  <tr>
                     <td style="width: 35%">氏名</td>
                     <td style="width: 65%"><span>{{ $user['name'] }}</span></td>
                  </tr>
                  <tr>
                     <td>紹介</td>
                     <td style="white-space: pre-wrap;"><span>{{ $user['intro'] }}</span></td>
                  </tr>
                  <tr>
                     <td>メール</td>
                     <td><span>{{ $user['email'] }}</span></td>
                  </tr>
                  <tr>
                     <td>画像</td>
                     <td><span class="thumbnail"><img src="{{ asset('/images/dogs/' . $user['img_no'] . '.jpg') }}" width="100%"></span></td>
                  </tr>
                  <tr>
                     <td>ログインカウント</td>
                     <td><span>{{ $user['login_count'] }}</span></td>
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
<script src="{{ asset('js/admin/button.js') }}"></script>

<script>
   function deleteUser(e) {
      if (confirm('会員情報を削除します。')) {
         document.getElementById('user_{{ $user->id }}').submit();
      }
   }
</script>
@endsection