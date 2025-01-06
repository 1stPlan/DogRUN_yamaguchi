@extends('admin.layouts.app_admin')

@section('css')
   <link rel="stylesheet" href="{{ asset('vendor/jquery-bootgrid/dist/jquery.bootgrid.css') }}">
@endsection

@section('sidebar_first_level_active', 'user_contact')

@section('content')
<section class="section-container">
   <!-- Page content-->
   <div class="content-wrapper">
      <div class="content-heading">
         <div>Data Tables<small>Tables, one step forward.</small></div>
      </div>
      <div class="container-fluid">
         <!-- DATATABLE DEMO 1-->
         <div class="card">
           <div class="d-flex align-items-center justify-content-between">
            <div class="card-header font-weight-bold">お問い合わせ情報詳細</div>
              <div class="d-flex mr-5" >
                <a href="{{ route('admin.contact.index') }}" class="btn btn-info command-deletem ml-3"><em class="fa fa-history"></em></a>
                <a href="#" class="btn  btn-warning command-deletem ml-3" onclick="deleteUser(this);" data-id="user_id"><em class="fa fa-trash fa-fw"></em></a>   <!-- thisは戻り値として -->
                {{-- <form action="{{ route('admin.users.destroy', $user) }}" id="user_{{ $user->id }}" method="POST">
                  @csrf
                  @method('DELETE') --}}
                </form>

                {{-- <a href="{{ route('admin.viewing_history', $user) }}" class="btn btn-success command-deletem ml-3">閲覧履歴を見る</em></a> --}}
              </div>
           </div>
            <table class="table table-bordered table-striped" id="user" style="clear: both">
               <tbody>
                 <tr>
                    <td style="width: 35%">会員ID</td>
                    <td style="width: 65%"><span>{{ $contact['id'] }}</span></td>
                 </tr>
                  <tr>
                     <td style="width: 35%">氏名</td>
                     <td style="width: 65%"><span>{{ $contact['name_top'] }} {{ $contact['name_bottom'] }}</span></td>
                  </tr>
                  <tr>
                     <td>mail address</td>
                     <td><span>{{ $contact['mail'] }}</span></td>
                  </tr>
                  <tr>
                     <td>内容</td>
                     <td><span>{{ $contact['content'] }}</span></td>
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
  {{-- <script src="{{ asset('js/admin/delete.js') }}"></script> --}}
  <script>
  function deleteUser(e) {
    if (confirm('会員情報を削除します。')) {
        document.getElementById('user_{{ $contact->id }}').submit();
    }
  }
</script>
@endsection
