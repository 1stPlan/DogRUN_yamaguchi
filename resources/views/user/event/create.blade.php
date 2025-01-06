@extends('user.layouts.app_user')
@section('title','DogRUN | イベント作成')

@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('css/page/user/event/event_create.css') }}">
@endsection

@section('content')


<section class="event_create">
  <!-- Page content-->
  <h3 class="event_create__title">EVENT CREATE</h3>
  <div class="event_create__page_header"></div>

  <div class="event_create__inner">
    <div class="event_create__cont">

      <div class="event_create__errors">
        @if ($errors->all())
        @foreach($errors->all() as $error)
        <p>{{ $error }}</p>
        @endforeach
        @endif
      </div>

      <form action="{{ route('user.event.store') }}" method="post" enctype="multipart/form-data">
        {{ csrf_field() }}


        <table class="event_create__table">
          <tbody class="event_create__table-body">

            <tr class="event_create__table-tr">
              <th class="event_create__table-th">タイトル</th>
              <td class="event_create__table-td">
                <input name="title" type="text" class="form-control" value="{{ old('title') }}">
              </td>
            </tr>

            <tr class="event_create__table-tr">
              <th class="event_create__table-th">開催日時</th>
              <td class="event_create__table-td">
                <div class="event_create__table-date">
                  <span class="event_create__table-icon">
                    <i class="fa fa-calendar"></i>
                  </span>
                  <input name="start_datetime" type="datetime" class="form-control date_picker" value="{{ old('close_datetime', "2024-07-01") }}">
                </div>
              </td>
            </tr>

            <tr class="event_create__table-tr">
              <th class="event_create__table-th">終了日時</th>
              <td class="event_create__table-td">
                <div class="event_create__table-date">
                  <span class="event_create__table-icon">
                    <i class="fa fa-calendar"></i>
                  </span>
                  <input name="close_datetime" type="datetime" class="form-control date_picker" value="{{ old('close_datetime', "2024-07-01") }}">
                </div>
              </td>
            </tr>

            <tr class="event_create__table-tr">
              <th class="event_create__table-th">カテゴリー</th>
              <td class="event_create__table-td">
                <select class="form-control" name="event_search_category_id">
                  @foreach($event_categories as $event_category)
                  <option value="{{ $event_category->id }}">{{ $event_category ->category}}</option>
                  @endforeach
                </select>
              </td>
            </tr>

            <tr class="event_create__table-tr">
              <th class="event_create__table-th">定員</th>
              <td class="event_create__table-td">
                <input name="capacity" type="text" class="form-control" value="{{ old('capacity') }}">
              </td>
            </tr>

            <tr class="event_create__table-tr">
              <th class="event_create__table-th">申込締め切り日時</th>
              <td class="event_create__table-td">
                <div class="event_create__table-date">
                  <span class="event_create__table-icon">
                    <i class="fa fa-calendar"></i>
                  </span>
                  <input name="entry_deadline_datetime" type="datetime" class="form-control date_picker" value="{{ old('close_datetime', "2024-07-01") }}">
                </div>
              </td>
            </tr>

            <tr class="event_create__table-tr">
              <th class="event_create__table-th">サムネイル画像</th>
              <td class="event_create__table-td">
                <input name="img_url" type="file" class="form-control" value="{{ old('img_url') }}">
              </td>
            </tr>

            <tr class="event_create__table-tr">
              <th class="event_create__table-th">使用ツール</th>
              <td class="event_create__table-td">
                <select class="form-control" name="tool">
                  <option value="Zoom" @if(old('tool')=='Zoom' ) selected @endif>Zoom</option>
                </select>
              </td>
            </tr>

            <tr class="event_create__table-tr">
              <th class="event_create__table-th">URL【 ZOOM 】</th>
              <td class="event_create__table-td">
                <input name="tool_url" type="text" class="form-control" value="{{ old('tool_url') }}">
              </td>
            </tr>

            <tr class="event_create__table-tr">
              <th class="event_create__table-th">password【 ZOOM 】</th>
              <td class="event_create__table-td">
                <input name="tool_password" type="text" class="form-control" value="{{ old('tool_password') }}">
              </td>
            </tr>

            <tr class="event_create__table-tr">
              <th class="event_create__table-th">説明</th>
              <td class="event_create__table-td">
                <textarea name="body" class="form-control">{{ old('summary') }}</textarea>
              </td>
            </tr>

            <tr class="event_create__table-tr">
              <th class="event_create__table-th">参加者への特記事項</th>
              <td class="event_create__table-td">
                <textarea name="remarks" class="form-control">{{ old('summary') }}</textarea>
              </td>
            </tr>


          </tbody>
        </table>

        <div class="event_create__btn">
          <a class="btn btn-white" href="{{ route('user.event') }}">戻る</a>
          <button class="btn btn-primary" type="submit">登録する</button>
        </div>

      </form>
    </div>

  </div>
</section>
@endsection


<!-- Datatables-->
@section('script')



@endsection