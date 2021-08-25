@extends('admin.layouts.app_admin')

@section('css')
<link rel="stylesheet" href="{{ asset('vendor/jquery-bootgrid/dist/jquery.bootgrid.css') }}">
@endsection

@section('sidebar_first_level_active', 'user_post')

@section('content')
<section class="section-container">
   <!-- Page content-->
   <div class="content-wrapper">
      <div class="content-heading">
         ショップ一覧
      </div>
      <div class="container-fluid">
         <!-- DATATABLE DEMO 1-->
         <div class="card">
            <div class="card-header">
            </div>
            <div class="card-body">
               <div class="table-responsive bootgrid">
                  <table class="table table-striped" id="bootgrid-button_post">
                     <thead>
                        <tr>
                           <th data-column-id="id" data-type="numeric">ID</th>
                           <th data-column-id="name">名前</th>
                           <th data-column-id="address">住所</th>
                           <th data-column-id="commands" data-formatter="commands" data-sortable="false">
                              <div class="text-right"></div>
                           </th>
                           <th data-column-id="commands" data-formatter="commands" data-sortable="false">
                              <div class="text-right"></div>
                           </th>
                           <th data-column-id="commands" data-formatter="commands" data-sortable="false">
                              <div class="text-right"></div>
                           </th>
                        </tr>
                     </thead>
                     <tbody>

                        @forelse ($places as $place)
                        <tr>
                           <td>{{ $place->id }}</td>
                           <td data-column-id="title">{{ $place->name }}</td>
                           <td data-column-id="body">{{ $place->address }}</td>

                           <td>
                              <a href="{{ route('admin.places.show', $place->id ) }}" class="btn btn-info btn-sm command-deletem">詳細</a>
                           </td>
                           <td>
                              <a href="{{ route('admin.places.edit', $place->id) }}" class="btn btn-info btn-sm command-deletem">編集</a>
                           </td>
                           <td>
                              <a href="{{ route('admin.places.post.index', $place->id) }}" class="btn btn-primary btn-sm">口コミ一覧</a>
                           </td>
                        </tr>
                        </a>
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
<script src="{{ asset('js/admin/button.js') }}"></script>
@endsection