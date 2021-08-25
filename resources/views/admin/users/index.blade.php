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
         ユーザー情報照会
      </div>
      <div class="container-fluid animated fadeInRight">
         <!-- DATATABLE DEMO 1-->
         <div class="card admin_card">
            <div class="card-header">
            </div>
            <div class="card-body">
               <div class="table-responsive bootgrid">
                  <table class="table table-striped" id="bootgrid-button">
                     <thead>
                        <tr>
                           <th data-column-id="id" data-type="numeric">ID</th>
                           <th data-column-id="name">名前</th>
                           <th data-column-id="address">メールアドレス</th>

                           <th data-column-id="date">登録日</th>
                           <th data-column-id="commands" data-formatter="commands" data-sortable="false">
                              <div class="text-right"></div>
                           </th>
                           <th data-column-id="commands" data-formatter="commands" data-sortable="false">
                              <div class="text-right"></div>
                           </th>
                        </tr>
                     </thead>
                     <tbody>

                        @forelse ($users as $user)

                        <tr>
                           <td>{{$user->id}}</td>
                           <td data-column-id="name">{{ $user->name }}</td>
                           <td data-column-id="address">{{ $user->email }}</td>
                       
                           <td>{{ $user->created_at->format('Y.m.d') }}</td>
                           <td>
                              <a href="{{ route('admin.users.show', $user->id ) }}" class="btn btn-info btn-sm command-deletem">詳細</a>
                           </td>
                        </tr>

                        @empty
                        @endforelse

                     </tbody>
                  </table>
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


@endsection