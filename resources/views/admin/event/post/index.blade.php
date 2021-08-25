@extends('admin.layouts.app_admin')

@section('css')
<link rel="stylesheet" href="{{ asset('vendor/jquery-bootgrid/dist/jquery.bootgrid.css') }}">
@endsection

@section('js')
<script>
   $(document).ready(function() {

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
               document.getElementById('comment_' + id).submit();
            }
         });
      });

   });
</script>
@endsection

@section('sidebar_first_level_active', 'user_post')

@section('content')
<section class="section-container">
   <!-- Page content-->
   <div class="content-wrapper">
      <div class="content-heading">
         {{ $event->title }} 
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
                           <th data-column-id="id" data-type="numeric" style="width: 10%">ID</th>
                           <th data-column-id="body" style="width: 60%">内要</th>
                           <th data-column-id="user_id" style="width: 10%">作成者ID</th>
                           <th data-column-id="created_date" style="width: 10%">作成日</th>
                           <th data-column-id="commands" data-formatter="commands" data-sortable="false" style="width: 10%">
                              <div class="text-right"></div>
                           </th>
                        </tr>
                     </thead>
                     <tbody>

                        @forelse ($post->comments as $index => $comment)

                        <form action="{{ route('admin.comment.destroy',  $comment->id) }}" id="comment_{{ $comment->id }}" method="POST">
                           @csrf
                           @method('DELETE')
                        </form>

                        <tr>
                           <td>{{ $index }}</td>
                           <td data-column-id="body">{{ $comment->body }}</td>
                           <td data-column-id="user_id">{{ $comment->user_id }}</td>
                           <td data-column-id="created_date">{{ $post->created_at->format('Y.m.d') }}</td>
                           <td>
                              <button class="btn btn-danger btn-sm delete" data-id="{{ $comment->id }}">削除</button>
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