@extends('user.layouts.app_user')

@section('title', "DogRUN" | $post->title)

@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('css/page/user/post/post_show.css') }}">
<style>
/* コメントフォームのツールチップ */
.comment_form__form {
  position: relative;
}

.tooltip-message {
  position: absolute;
  top: -50px;
  left: 50%;
  transform: translateX(-50%);
  background-color: #333;
  color: white;
  padding: 8px 12px;
  border-radius: 6px;
  font-size: 12px;
  white-space: nowrap;
  opacity: 0;
  visibility: hidden;
  transition: all 0.3s ease;
  z-index: 1000;
  pointer-events: none;
}

.tooltip-message::after {
  content: '';
  position: absolute;
  top: 100%;
  left: 50%;
  transform: translateX(-50%);
  border: 6px solid transparent;
  border-top: 6px solid #333;
}

/* フォームにホバーしたらツールチップを表示 */
.comment_form__form:hover .tooltip-message {
  opacity: 1;
  visibility: visible;
}

/* 無効化されたsubmitボタンのスタイル */
.comment_form__submit--disabled {
  background-color: #ccc;
  color: #666;
  cursor: not-allowed;
  opacity: 0.6;
}

.comment_form__submit--disabled:hover {
  background-color: #ccc;
  transform: none;
}

/* 無効化されたインプットフィールドのスタイル */
.comment_form__input--disabled {
  background-color: #f5f5f5;
  color: #999;
  cursor: not-allowed;
  opacity: 0.7;
  border: 1px solid #ddd;
}

.comment_form__input--disabled:focus {
  outline: none;
  border-color: #ddd;
  box-shadow: none;
}
</style>
@endsection

@section('content')

<section class="post_show">
  <div class="post_show__inner">

    <div class="floating__banner">
      <button class="floating__banner-close">×</button>
      <a href="{{ route('user.event.show', ['event' => $post->event_id ]) }}">
        <div class="floating__banner-back">
          <div class="floating__banner-body">
            <span>リストに戻る</span>
          </div>
        </div>
      </a>
    </div>

    <div class="post_show__cont">
      <h3 class="post_show__cont-body">{{ $post->title }}</h3>
      <div class="post_show__cont-pic">
        <img src="{{ $post->img_url ? asset( 'storage/image/event/'. $post->img_url.'.jpg') : asset('/images/icon.png') }}">
      </div>
    </div>

    <ul class="post_show__list">
      @forelse ($post->comments as $comment)
        <!-- @if($comment->delete == 0) -->
          @if($comment->user_id == Auth::id())
            <li class="post_show__item  post_show__item--balloon_r">
              @foreach ($users as $user)
                @if($user->id == $comment->user_id)
                  <p class="post_show__item-text">{{ $comment->body }}<a href="#" class="del" onclick="deletePost(this);" data-id="{{ $comment->id }}">[x]</a></p>
                  <a class="post_show__item-link" tabindex="-1">
                    <div class="post_show__item-pic">
                      @if($user->img_no)
                      <img src="{{ asset('/images/dogs/' . $user->img_no . '.jpg') }}" alt="" width="100%">
                      @else
                      <img src="{{ asset('/images/sample.png') }}" alt="" width="100%">
                      @endif
                    </div>
                  </a>
                @endif
              @endforeach
            </li>

            <form method="post" action="{{ action('User\Event\EventCommentController@destroy', $comment) }}" id="form_{{ $comment->id }}">
              {{ csrf_field() }}
              {{ method_field('delete') }}
            </form>
          @else
            <li class="post_show__item  post_show__item--balloon_l">
              @foreach ($users as $user)
                @if($user->id == $comment->user_id)
                  <a class="post_show__item-link" tabindex="-1" onclick="showProfile(this);" data-id="{{ $user->id }}" data-name="{{ $user->name }}" data-img="{{ $user-> img_no }}" data-type="{{ $user-> type }}" data-login_count="{{ $user-> login_count }}" data-target="{{ $user-> intro }}">
                    <div class="post_show__item-pic">
                      @if($user->img_url)
                      <img class="post_show__item-img" src="{{ $user-> img_url }}" alt="" width="100%">
                      @else
                      <img class="post_show__item-img" src="{{ asset('/images/sample.png') }}" alt="" width="100%">
                      @endif
                    </div>
                  </a>
                  <p class="post_show__item-text">{{ $comment->body }}</p>
                @endif
              @endforeach
            </li>
          @endif
         <!-- @endif -->
      @empty
      <li>【 初めのコメントを投稿してください。 】</li>
      @endforelse
    </ul>

  </div>

  </div>
</section>

<section class="comment_form">
  <div class="comment_form__inner">
    <div class="comment_form__circle-spase">
      <div class="comment_form__circle" id="form_circle">
        <span class="comment_form__circle-span"></span>
      </div>
    </div>


    <form class="comment_form__form" method="post" action="{{ route('user.event.comment.store', $post) }}">
      {{ csrf_field() }}
      @auth
        <input class="comment_form__input" type="text" name="body" placeholder="" value="{{ old('body') }}">
        @if ($errors->has('body'))
        <span class="error">{{ $errors->first('body') }}</span>
        @endif
        <input class="comment_form__submit" type="submit" value="コメント">
      @else
        <input class="comment_form__input comment_form__input--disabled" type="text" name="body" placeholder="" value="" disabled>
        <input class="comment_form__submit comment_form__submit--disabled" type="button" value="コメント" disabled>
      @endauth

      <!-- ツールチップ（ログインしていない場合のみ表示） -->
      @guest
        <div class="tooltip-message">ログインが必要です</div>
      @endguest
    </form>

  </div>
</section>



@endsection