@extends('user.layouts.app_user')
@section('title','DogRUN | イベント紹介')

@section('meta')
@endsection

@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('css/page/user/event/event.css') }}">

@endsection

@section('content')

<section class="event">

  <div class="event__page_header">
    <h3 class="event__page_title">DOG EVENT</h3>
    <span class="event__page_exp">【 山口県限定 】</span>
  </div>

  <div class="event__inner">
    <div class="event__cont">

      <h3 class="event__sub-title">新着イベント</h3>

      <div class="event__desc">
        山口県で行われる予定のドッグイベントの新着情報
      </div>

      <div class="event__mv">
        <ul class="event__mv-list" id="event_mv">
          @foreach($events as $index => $event)
          @if ($loop->index <= 5)

            <li class="event__mv-item">
            <a class="event__mv-link" href="{{ route('user.event.show', ['event' => $event->id ]) }}">
              <img class="event__mv-img" src="{{ $event->img_url ? asset( 'storage/image/event/'. $event->img_url.'.jpg') : asset('/images/icon.png') }}">
            </a>
            </li>
            @endif
            @endforeach
        </ul>
      </div>

      <ul class="event__list" id="event_list">

        @foreach($events as $index => $event)
        @if ($loop->index <= 5)

          <li class="event__item">
          <a class="event__link" href="{{ route('user.event.show', ['event' => $event->id ]) }}">

            <div class="event__info">
              <h4 class="event__info-tit">
                @php
                if (mb_strlen($event->title) > 27) {
                $title = mb_substr($event->title, 0, 27);
                $replace = preg_replace("/( |　)/", '', $title);
                echo $replace . '...';
                } else {
                $title = $event->title;
                $replace = preg_replace("/( |　)/", '', $title);
                echo $replace;
                }
                @endphp
              </h4>
              <p class="event__info-date">
                {{ $event->created_at->format('Y年m月d日')}}
              </p>

              <div class="event__info-txt">
                <p class="event__info-body">
                  @php
                  if (mb_strlen(nl2br($event->body)) > 55) {
                  $body = mb_substr(nl2br($event->body), 0, 55);
                  $replace = preg_replace(array('/( |　)/', '/<br>/'), '', $body);
                  echo $replace . '...';
                  } else {
                  $body = $event->body;
                  $replace = preg_replace(array('/( |　)/', '/<br>/'), '', $body);
                  echo $replace;
                  }
                  @endphp

                </p>
                <p class="event__info-startdate"><span>開催日</span>{{ $event->start_datetime->format('Y年m月d日') }}</p>
                <p class="event__info-tool"><span>開催場所</span>{{ $event->venue }}</p>
              </div>
            </div>

          </a>
          </li>

          @endif
          @endforeach
      </ul>

      <h3 class="event__sub-title">イベント一覧</h3>

      <div class="event__desc">
        山口県で行われたドッグイベントの一覧
      </div>
      <ul class="event__tag">
        <li class="event__tag-item is-active" data-group="">ALL</li>
        <li class="event__tag-item" data-group="1">EVENT</li>
        <li class="event__tag-item" data-group="2">SHOP</li>
      </ul>

      <ul class="event__all-list" id="event_all-list">
        @foreach($events as $index => $event)


        @if($now < $event->start_datetime)
          <li class="event__all-item event__all-item--y" data-group="{{ $event->categoryid }}">
            <div class="event__all-batch event__all-batch--y">参加可能</div>
            @else
          <li class="event__all-item event__all-item--n" data-group="{{ $event->categoryid }}">
            <div class="event__all-batch event__all-batch--n">終了</div>
            @endif

            <a class="event__all-link" href="{{ route('user.event.show', ['event' => $event->id ]) }}">

              <div class="event__all-info">
                <div class="event__all-info-pic">
                  <img class="event__all-info-img" src="{{ $event->img_url ? asset( 'storage/image/event/'. $event->img_url.'.jpg') : asset('/images/icon.png') }}">
                </div>
                <div class="event__all-info-txt">
                  <h4 class="event__all-info-tit">
                    @php
                    if (mb_strlen($event->title) > 27) {
                    $title = mb_substr($event->title, 0, 27);
                    $replace = preg_replace("/( |　)/", '', $title);
                    echo $replace . '...';
                    } else {
                    $title = $event->title;
                    $replace = preg_replace("/( |　)/", '', $title);
                    echo $replace;
                    }
                    @endphp
                  </h4>
                  <p class="event__all-info-body">
                    <!-- {!! nl2br($event->body) !!} -->
                    @php
                    if (mb_strlen(nl2br($event->body)) > 40) {
                    $body = mb_substr(nl2br($event->body), 0, 40);
                    $replace = preg_replace(array('/( |　)/', '/<br>/'), '', $body);
                    echo $replace . '...';
                    } else {
                    $body = $event->body;
                    $replace = preg_replace(array('/( |　)/', '/<br>/'), '', $body);
                    echo $replace;
                    }
                    @endphp
                  </p>
                  <p class="event__all-info-date"><span>開催日</span>{{ $event->start_datetime->format('Y年m月d日') }}</p>
                </div>
              </div>

            </a>
          </li>
          @endforeach

      </ul>

    </div>

  </div>
</section>

@endsection

@section('script')
<script src="{{ asset('js/paginathing.min.js') }}"></script>

<script type="text/javascript">
  //Eventでの情報絞り込み

  var searchItem = '.event__tag-item'; // 絞り込む項目を選択するエリア
  var listItem = '.event__all-item'; // 絞り込み対象のアイテム
  var hideClass = 'is-hide'; // 絞り込み対象外の場合に付与されるclass名
  var activeClass = 'is-active'; // 選択中のグループに付与されるclass名

  $(function() {
    // 絞り込みを変更した時
    $(searchItem).on('click', function() {
      $(searchItem).removeClass(activeClass);
      var group = $(this).addClass(activeClass).data('group');

      search_filter(group);
    });
  });

  /**
   * リストの絞り込みを行う
   * @param {String} group data属性の値
   */
  function search_filter(group) {

    // 非表示状態を解除
    $(listItem).removeClass(hideClass);
    // 値が空の場合はすべて表示
    if (group === '') {
      return;
    }


    // リスト内の各アイテムをチェック
    for (var i = 0; i < $(listItem).length; i++) {
      // アイテムに設定している項目を取得
      var itemData = $(listItem).eq(i).data('group');
      // 絞り込み対象かどうかを調べる
      if (itemData !== group) {
        $(listItem).eq(i).addClass(hideClass);
      }
    }
  }


  //pagenationの設定
  $(function() {
    $('#event_all-list').paginathing({ //親要素のclassを記述
      perPage: 12, //1ページあたりの表示件数
      prevText: '前へ', //1つ前のページへ移動するボタンのテキスト
      nextText: '次へ', //1つ次のページへ移動するボタンのテキスト
      activeClass: 'navi-active', //現在のページ番号に任意のclassを付与できます
      firstLast: false
    })
  });
</script>
@endsection