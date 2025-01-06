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
         ポスト
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
                           <th data-column-id="body">内要</th>
                           <th data-column-id="user">作成者</th>
                           <th data-column-id="created_date">作成日</th>
                           <th data-column-id="commands" data-formatter="commands" data-sortable="false">
                            <div class="text-right"></div>
                           </th>
                        </tr>
                     </thead>
                     <tbody>

                        @forelse ($comments as $comment)

                        <tr>
                           <td>{{ $comment->id }}</td>
                           <td data-column-id="body">{{ $comment->body }}</td>
                           <td data-column-id="user">{{ $comment->user }}</td>
                           <td data-column-id="created_date">{{ $comment->created_at->format('Y.m.d') }}</td>
                           <td>
                              {{-- <a href="{{ route('admin.comment.show', $post['id']) }}" class="btn btn-info btn-sm command-deletem">詳細</a> --}}
                           </td>
                           {{-- <td>
                              <a href="{{ route('admin.post.edit', $post['id']) }}" class="btn btn-info btn-sm command-deletem">編集</a>
                           </td> --}}
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
