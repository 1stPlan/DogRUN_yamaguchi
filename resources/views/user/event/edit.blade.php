@extends('user.layouts.app_user')
@section('title','DogRUN | イベント編集')

@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('css/page/user/event/event_edit.css') }}">
@endsection

@section('content')

<section class="event_edit">
  <!-- Page content-->
  <h3 class="event_edit__title">EVENT EDIT</h3>
  <div class="event_edit__page_header"></div>

  <div class="event_edit__inner">

    <div class="event_edit__cont">

      <div class="event_edit__errors">
        @if ($errors->all())
        @foreach($errors->all() as $error)
        <p>{{ $error }}</p>
        @endforeach
        @endif
      </div>

      <form action="{{ route('user.event.update', $event->id) }}" method="post" class="form-horizontal" enctype="multipart/form-data">
        {{ csrf_field() }}
        {{ method_field('patch') }}

        <table class="event_edit__table">
          <tbody class="event_edit__table-body">

            <tr class="event_edit__table-tr">
              <th class="event_edit__table-th">タイトル</th>
              <td class="event_edit__table-td">
                <input name="title" type="text" class="form-control" value="{{ old('title') }}">
              </td>
            </tr>

            <tr class="event_edit__table-tr">
              <th class="event_edit__table-th">イベント詳細</th>
              <td class="event_edit__table-td">
                <textarea name="body" class="form-control event_edit__detail">{{ old('body') }}</textarea>
              </td>
            </tr>

            <tr class="event_edit__table-tr">
              <th class="event_edit__table-th">開催日時</th>
              <td class="event_edit__table-td">
                <div class="event_edit__table-date">
                  <span class="event_edit__table-icon">
                    <i class="fa fa-calendar"></i>
                  </span>
                  <input name="start_datetime" type="datetime" class="form-control date_picker" value="{{ old('close_datetime', "2024-07-01") }}">
                </div>
              </td>
            </tr>

            <tr class="event_edit__table-tr">
              <th class="event_edit__table-th">終了日時</th>
              <td class="event_edit__table-td">
                <div class="event_edit__table-date">
                  <span class="event_edit__table-icon">
                    <i class="fa fa-calendar"></i>
                  </span>
                  <input name="close_datetime" type="datetime" class="form-control date_picker" value="{{ old('close_datetime', "2024-07-01") }}">
                </div>
              </td>
            </tr>

            <tr class="event_edit__table-tr">
              <th class="event_edit__table-th">カテゴリー</th>
              <td class="event_edit__table-td">
                <select class="form-control" name="event_search_category_id">
                  @foreach($event_categories as $event_category)
                  <option value="{{ $event_category->id }}">{{ $event_category ->category}}</option>
                  @endforeach
                </select>
              </td>
            </tr>

            <tr class="event_edit__table-tr">
              <th class="event_edit__table-th">定員</th>
              <td class="event_edit__table-td">
                <input name="capacity" type="text" class="form-control" value="{{ old('capacity') }}">
              </td>
            </tr>

            <!-- <tr class="event_edit__table-tr">
              <th class="event_edit__table-th">申込締め切り日時</th>
              <td class="event_edit__table-td">
                <div class="event_edit__table-date">
                  <span class="event_edit__table-icon">
                    <i class="fa fa-calendar"></i>
                  </span>
                  <input name="entry_deadline_datetime" type="datetime" class="form-control date_picker" value="{{ old('close_datetime', "2024-07-01") }}">
                </div>
              </td>
            </tr> -->

            <tr class="event_edit__table-tr">
              <th class="event_edit__table-th">サムネイル画像</th>
              <td class="event_edit__table-td">
                <input name="img_url" type="file" class="form-control" value="{{ old('img_url') }}">
              </td>
            </tr>

            <tr class="event_edit__table-tr">
              <th class="event_edit__table-th">使用ツール</th>
              <td class="event_edit__table-td">
                <select class="form-control" name="tool">
                  <option value="Zoom" @if(old('tool')=='Zoom' ) selected @endif>Zoom</option>
                </select>
              </td>
            </tr>

            <tr class="event_edit__table-tr">
              <th class="event_edit__table-th">URL【 ZOOM 】</th>
              <td class="event_edit__table-td">
                <input name="tool_url" type="text" class="form-control" value="{{ old('tool_url') }}">
              </td>
            </tr>

            <tr class="event_edit__table-tr">
              <th class="event_edit__table-th">password【 ZOOM 】</th>
              <td class="event_edit__table-td">
                <input name="tool_password" type="text" class="form-control" value="{{ old('tool_password') }}">
              </td>
            </tr>

            <tr class="event_edit__table-tr">
              <th class="event_edit__table-th">参加者への特記事項</th>
              <td class="event_edit__table-td">
                <textarea name="remarks" class="form-control">{{ old('remarks') }}</textarea>
              </td>
            </tr>

          </tbody>
        </table>

        <div class="event_edit__btn">
          <a class="btn btn-white" href="{{ route('user.setting') }}">戻る</a>
          <button class="btn btn-primary" type="submit">登録する</button>
        </div>

    </div>
  </div>
  </form>

  </div>
  </div>
</section>


@endsection

<!-- Datatables-->
@section('script')
@endsection