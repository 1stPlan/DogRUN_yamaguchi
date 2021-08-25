@extends('user.layouts.app_user')
@section('title','DogRUN | イベント編集')

@section('meta')
@endsection

@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('css/page/user/event/event_show.css') }}">

@endsection

@section('content')

<section class="event_show">
  <!-- Page content-->
  <div class="event_show__inner">
    <div class="event_show__cont">

      <div class="event_show__info">
        <h4 class="event_show__info-tit">
          {{ $event->title }}
        </h4>
        <p class="event_show__info-cd">
          {{ $event->created_at->format('Y.m.d')}}
        </p>
        <div class="event_show__info-pic">
          <img class="event_show__info-img" src="{{ $event->img_url ? asset( 'storage/image/event/'. $event->img_url.'.jpg') : asset('/images/icon.png') }}" alt="" width="100%">
        </div>

        <table class="event_show__info-table">
          <tbody>
            <tr>
              <th>イベント詳細</th>
              <td>{!! nl2br($event->body) !!}</td>
            </tr>
            <tr>
              <th>開催日時</th>
              <td>{{ $event->start_datetime->format('Y年m月d日 H時i分') }}</td>
            </tr>
            <tr>
              <th>開催場所</th>
              <td> {{ $event->venue }}</td>
            </tr>
            <tr>
              <th>料金</th>
              <td>{{ $event->ticket_price }} 円</td>
            </tr>
            <tr>
              <th>参加者への特記事項</th>
              <td>{!! nl2br($event->remarks) !!}</td>
            </tr>

            @if ( $participant_flg == 1)
            <tr>
              <th>参加者用掲示板</th>
              <td><a href="{{ route('user.event.post.show', ['event' => $event->id] ) }}">参加者用掲示板Link</a></td>
            </tr>

            @endif

          </tbody>
        </table>


      </div>

    </div>


    @if( Auth::check() )
    <form action="{{ route('user.event.participant', $event->id) }}" method="post" class="event_show__form">
      {{ csrf_field() }}
      <button class="event_show__btn" type="submit">{{ $participant_flg == 0 ? '参加する' : '参加済み' }}</button>
    </form>
    @endif

    <a class="event_show__btn" href="{{ route('user.event') }}">戻る</a>

  </div>
</section>

@endsection