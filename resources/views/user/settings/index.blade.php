@extends('user.layouts.app_user')
@section('title','DogRUN | MYPAGE')

@section('meta')
@endsection

@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('css/page/user/setting/setting.css') }}">
@endsection

@section( 'script' )
@endsection

@section('content')

<section class="setting">
  <div class="setting__inner">
    <h3 class="setting__title">MYPAGE</h3>
    <ul class="setting__cards" id="accordion">

      <li class="setting__card">
        <div class="setting__card-header" id="headingOne">
          <a data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne" href="">基本情報</a>
        </div>

        <div class="floating__banner">
          <button class="floating__banner-close">×</button>
          <a tabindex="-1" onclick="showProfile(this);" data-id="{{ $user->id }}" data-name="{{ $user->name }}" data-img="{{ $user-> img_no }}" data-type="{{ $user-> type }}" data-login_count="{{ $user-> login_count }}" data-target="{{ $user-> intro }}">
            <div class="floating__banner-back">
              <div class="floating__banner-body">
                <i class="fas fa-pen"></i>
                <span>プロフィールカード表示</span>
              </div>
            </div>
          </a>
        </div>

        <div class="collapse show" id="collapseOne" aria-labelledby="headingOne">

          <div class="setting__card-commands">
            <a href="{{ action('User\SettingController@edit',$user->id) }}" class="setting__card-command btn btn-warning command-deletem">
              編集する
            </a>
            <a href="{{  route('password.request') }}" class="setting__card-command btn btn-warning command-deletem">
              パスワード編集する
            </a>
            <a href="{{ route('user.setting.withdrawl') }}" class="setting__card-command btn btn-warning command-deletem del">
              アカウント削除
            </a>
          </div>

          <table class="setting__card-table setting__card-table--profile table">
            <tbody>
              <tr>
                <th>ニックネーム</th>
                <td>{{ $user->name }}</td>
              </tr>
              <tr>
                <th>メールアドレス</th>
                <td>{{ $user->email }}</td>
              </tr>
              <tr>
                <th>自己紹介</th>
                <td class="setting__card-td-height">{{ $user->intro }}</td>
              </tr>
              <tr>
                <th>登録画像</th>
                <td>
                  <div class="setting__card-pic">
                    <img class="setting__card-img" src="{{ asset('/images/dogs/' . $user->img_no . '.jpg') }}" width="100%">
                  </div>
                </td>
              </tr>
            </tbody>
          </table>

        </div>

      </li>


      <li class="setting__card">
        <div class="setting__card-header" id="headingTwo">
          <a class="collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo" href="">参加予定イベント</a>
        </div>
        <div class="collapse show" id="collapseTwo" aria-labelledby="headingTwo">
          <div class="setting__card-body">
            <table class="setting__card-table table table-striped">
              <thead>
                <tr>
                  <th>イベント名</th>
                  <th>日程</th>
                  <th data-column-id="commands" data-formatter="commands" data-sortable="false">
                    <div class=""></div>
                  </th>

                </tr>
              </thead>
              <tbody>
                @if(empty($participant))
                <tr>
                  <td>イベントなし</td>
                  <td></td>
                  <td></td>
                  <td></td>
                </tr>
                @else
                @foreach($participant as $index => $participant_list)

                <tr>
                  <td>{{ $participant_list->title }}</td>
                  <td>{{ $participant_list->start_datetime->format('y年n月d日') }}</td>
                  <td class="setting__commands">
                    <a href="" class="btn btn-primary command-deletem" data-toggle="modal" data-target="#eventModal{{ $participant_list->id }}">
                      詳細
                    </a>
                    <a tabindex="-1" class="del btn" onclick="deleteEvent(this);" data-id="{{ $participant_list->id }}">
                      キャンセル
                    </a>
                    <form method="post" action="{{ action('User\SettingController@event_destroy',$participant_list->id)}}" id="form_{{ $participant_list->id }}">
                      {{ csrf_field() }}
                      {{ method_field('delete') }}
                    </form>
                  </td>
                </tr>


                <!-- Modal -->
                <div class="modal fade" id="eventModal{{ $participant_list->id }}" tabindex="-1" role="dialog" aria-labelledby="eventModalLabel" aria-hidden="true">
                  <div class="modal-dialog setting__modal-dialog" role="document">
                    <div class="modal-content setting__modal-content">

                      <div class="modal-header setting__modal-header">
                        <h5 class="setting__modal-tit">
                          {{ $participant_list->title }}
                        </h5>
                      </div>
                      <div class="modal-body setting__modal-body">
                        <a href="{{ route('user.event.show', ['event' => $participant_list->id ]) }}">
                          <div class="setting__modal-pic">
                            <img src="{{ asset( 'storage/image/event/'. $participant_list->img_url.'.jpg') }}" alt="" width="100%">
                          </div>
                        </a>
                        <div class="setting__modal-day">
                          <span>日時</span>
                          <p>
                            {{ $participant_list->start_datetime->format('Y年n月d日 H時i分') }}
                          </p>
                        </div>
                        <div class="setting__modal-exp">
                          <span>詳細</span>
                          <p>
                            @php
                            if (mb_strlen(nl2br($participant_list->body)) > 200) {
                            $body = mb_substr(nl2br($participant_list->body), 0, 55);
                            $replace = preg_replace('/( |　)/', '', $body);
                            echo $replace . '...';
                            } else {
                            $body = $participant_list->body;
                            $replace = preg_replace('/( |　)/', '', $body);
                            echo $replace;
                            }
                            @endphp
                          </p>
                        </div>

                      </div>
                      <div class="modal-footer setting__modal-footer">
                        <button type="button" class="btn btn-secondary setting__modal-btn" data-dismiss="modal">閉じる</button>
                      </div>
                    </div>
                  </div>
                </div>

                @endforeach
                @endif
              </tbody>
            </table>
          </div>
        </div>
      </li>

    </ul>
  </div>


</section>

@endsection