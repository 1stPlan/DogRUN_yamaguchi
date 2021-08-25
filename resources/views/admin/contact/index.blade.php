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
         お問い合わせ
      </div>
      <div class="container-fluid">
         <!-- DATATABLE DEMO 1-->
         <div class="card">
            <div class="card-header">
            </div>
            <div class="card-body">
               <div class="table-responsive bootgrid">
                  <table class="table table-striped" id="bootgrid-button_contact">
                     <thead>
                        <tr>
                           <th data-column-id="id" data-type="numeric">ID</th>
                           <th data-column-id="name">名前</th>
                           <th data-column-id="mail">アドレス</th>
                           <th data-column-id="type">カテゴリ</th>
                           {{-- <th data-column-id="content" data-order="desc">内容</th> --}}
                           <th data-column-id="date">日時</th>

                           <th data-column-id="commands" data-formatter="commands" data-sortable="false">
                            <div class="text-right"></div>
                           </th>
                        </tr>
                     </thead>
                     <tbody>
                        @forelse ($contacts as $contact)

                        <tr>
                           <td>{{$contact->id}}</td>
                           <td data-column-id="name">{{ $contact->name_top }} {{ $contact->name_bottom }}</td>
                           <td data-column-id="mail">{{ $contact->mail }}</td>
                           <td data-column-id="type">{{ $contact->type }}</td>
                           {{-- <td data-column-id="content">{{ $contact->content }}</td> --}}
                           <td data-column-id="date">{{ $contact->created_at->format('Y.m.d') }}</td>
                           <td>
                              <a href="{{ route('admin.contact.show', $contact['id']) }}" class="btn btn-info btn-sm command-deletem">詳細</a>
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
  <script src="{{ asset('js/admin/button.js') }}"></script>
@endsection
