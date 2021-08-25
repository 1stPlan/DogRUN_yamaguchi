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
      {{ $place->name }} 口コミ一覧
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
                           <th data-column-id="id" data-type="numeric" style="width: 5%">ID</th>
                           <th data-column-id="tittle" style="width: 20%;">タイトル</th>
                           <th data-column-id="body" style="width: 40%;">内容</th>
                           <!-- <th data-column-id="user_id">ユーザーID</th> -->
                           <th data-column-id="name" style="width: 10%; text-align: center;">名前</th>
                           <!-- <th data-column-id="ip_address">ip_address</th> -->
                           <th data-column-id="rating" style="width: 7.5%; text-align: center;">評価</th>
                           <th data-column-id="like_count" style="width: 7.5%; text-align: center;">いいね</th>

                           <th data-column-id="commands" data-formatter="commands" data-sortable="false"  style="width: 8%">
                              <div class="text-right"></div>
                           </th>

                        </tr>
                     </thead>
                     <tbody>

                        @forelse ($posts as $index => $post)
                        <?php $index++; ?>
                        <tr>
                           <td>{{ $index }}</td>
                           <td data-column-id="title">{{ $post->tittle }}</td>
                           <td data-column-id="body">{{ $post->body }}</td>
                           <!-- <td data-column-id="user_id">{{ $post->user_id }}</td> -->
                           <td data-column-id="name" style="text-align: center">{{ $post->name }}</td>
                           <!-- <td data-column-id="ip_address">{{ $post->ip_address }}</td> -->
                           <td data-column-id="ip_address" style="text-align: center">{{ $post->rating }}</td>
                           <td data-column-id="ip_address" style="text-align: center">{{ $post->like_count }}</td>
                           <td><a href="" class="btn btn-info btn-sm command-deletem" style="text-align: center">削除</a></td>
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
<script src="{{ asset('js/admin/button.js') }}"></script>
@endsection