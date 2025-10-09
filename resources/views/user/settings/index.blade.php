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

    <!-- 基本情報セクション -->
    <div class="setting__profile">
      <div class="setting__profile-container">

        <div class="setting__profile-image-section">
          <div class="setting__profile-image-wrapper">
            @if($user->img_no)
              <img
                src="{{ asset('/images/dogs/' . $user->img_no . '.jpg') }}"
                alt="プロフィール画像"
                class="setting__profile-image"
                onerror="this.onerror=null; this.src='/images/dummy.png';"
              />
            @else
              <img
                src="{{ asset('/images/dummy.png') }}"
                alt="デフォルト画像"
                class="setting__profile-image"
              />
            @endif
          </div>
        </div>

        <div class="setting__profile-content">
          <div class="setting__profile-name-section">
            <p class="setting__profile-name">
              {{ $user->name }}
            </p>
          </div>

          <!-- アクションボタン -->
          <div class="setting__profile-actions">
            <a
              href="{{ action('User\SettingController@edit',$user->id) }}"
              class="setting__profile-action setting__profile-action--primary"
            >
              <i class="fas fa-user-cog setting__profile-action-icon"></i>
              プロフィール編集
            </a>
            <a
              href="{{ route('password.request') }}"
              class="setting__profile-action setting__profile-action--warning"
            >
              <i class="fas fa-key setting__profile-action-icon"></i>
              パスワード編集
            </a>
            <a
              href="{{ route('user.setting.withdrawl') }}"
              class="setting__profile-action setting__profile-action--danger"
            >
              <i class="fas fa-trash setting__profile-action-icon"></i>
              アカウント削除
            </a>
          </div>

          <div class="setting__profile-info">
            <div class="setting__profile-info-item">
              <label class="setting__profile-info-label">
                メール
              </label>
              <p class="setting__profile-info-value">
                {{ $user->email }}
              </p>
            </div>
            <div class="setting__profile-info-item">
              <label class="setting__profile-info-label">
                自己紹介
              </label>
              <p class="setting__profile-info-value setting__profile-info-value--multiline">{{ $user->intro ?: '未設定' }}</p>
            </div>
          </div>

        </div>
      </div>
    </div>

    <ul class="setting__cards" id="accordion">


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
                  <td>
                    <div class="setting__commands">
                      <a href="" class="btn btn-outline-primary" data-toggle="modal" data-target="#eventModal{{ $participant_list->id }}">
                        詳細
                      </a>
                      <a href="{{ route('user.event.post.show', ['event' => $participant_list->id]) }}" class="btn btn-outline-secondary">
                        掲示版
                      </a>
                      <a tabindex="-1" class="del btn btn-outline-danger" onclick="deleteEvent(this);" data-id="{{ $participant_list->id }}">
                        予定キャンセル
                      </a>
                      <form method="post" action="{{ action('User\SettingController@event_destroy',$participant_list->id)}}" id="form_{{ $participant_list->id }}">
                        {{ csrf_field() }}
                        {{ method_field('delete') }}
                      </form>
                    </div>
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