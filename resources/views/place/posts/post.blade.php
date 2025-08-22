@extends('user.layouts.app_user')
@section('title', 'DogRUN | 口コミ')

@section('meta')
@endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/page/user/post/post.css') }}">

@endsection

@section('content')


    <section class="post">
        <div class="post__inner">
            <div class="post__head">
                <div class="post__pic">
                    <img src="{{ asset('storage/image/shop/' . $place->id . '.jpg') }}" alt="">
                </div>
                <h3 class="post__title">{{ $place->name }} 口コミ</h3>
            </div>
            <div class="post__desc">
                他のユーザーの意見や体験をチェックできます。気になった内容には、評価を付けることが可能です。
            </div>
            <div class="post__cont">

                <ul class="post__list" id="post_list">
                    <!-- ここのpostsを変更する必要あり -->
                    @forelse ($posts as $post)
                        @if ($post->delete == 0)
                            <li class="post__item">
                                <div class="post__item-head">
                                    <div class="post__item-tit">{{ $post->tittle }}</div>
                                    @php $date = date('m/d', strtotime($post->created_at)); @endphp
                                    <div class="post__item-date">{{ $date }}</div>
                                </div>
                                <div class="post__item-body">{{ $post->body }}</div>


                                <!-- もし作成者なら削除、返信可能 -->

                                <div class="post__item-user-name">
                                    {{ $post->name }}
                                </div>

                                <div class="post__item-bottom">

                                    @if ($post['like'] == 1)
                                        <a class="post__item-liked{{ $post->id }}" href="javascript:void(0)"
                                            onclick="likedestroy({{ $post->id }})">
                                            <i class="far fa-heart"></i>: <span
                                                class="post__itemspan{{ $post->id }}">{{ $post['like_count'] }}</span>

                                        </a>
                                    @else
                                        <a class="post__item-like{{ $post->id }}" href="javascript:void(0)"
                                            onclick="postlike({{ $post->id }})">
                                            <i class="far fa-heart"></i>: <span
                                                class="post__itemspan{{ $post->id }}">{{ $post['like_count'] }}</span>
                                        </a>
                                    @endif

                                    <div class="post__item-rating">
                                        @if ($post->rating == 0)
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                        @elseif($post->rating == 1)
                                            <i style=" color: #c4c403;" class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                        @elseif($post->rating == 2)
                                            <i style=" color: #c4c403;" class="fas fa-star"></i>
                                            <i style=" color: #c4c403;" class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                        @elseif($post->rating == 3)
                                            <i style=" color: #c4c403;" class="fas fa-star"></i>
                                            <i style=" color: #c4c403;" class="fas fa-star"></i>
                                            <i style=" color: #c4c403;" class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                        @elseif($post->rating == 4)
                                            <i style=" color: #c4c403;" class="fas fa-star"></i>
                                            <i style=" color: #c4c403;" class="fas fa-star"></i>
                                            <i style=" color: #c4c403;" class="fas fa-star"></i>
                                            <i style=" color: #c4c403;" class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                        @elseif($post->rating == 5)
                                            <i style=" color: #c4c403;" class="fas fa-star"></i>
                                            <i style=" color: #c4c403;" class="fas fa-star"></i>
                                            <i style=" color: #c4c403;" class="fas fa-star"></i>
                                            <i style=" color: #c4c403;" class="fas fa-star"></i>
                                            <i style=" color: #c4c403;" class="fas fa-star"></i>
                                        @endif
                                    </div>
                                </div>

                                @php
                                    $user_id = $post->user_id;
                                    foreach ($users as $index => $user) {
                                        if ($user_id == $user->id) {
                                            $post_user = $user;
                                            break;
                                        }
                                    }
                                @endphp

                                @if ($post->user_id == Auth::id() || $post['sameIp'] == 1)
                                    <div class="post__item-form">
                                        <a href="#" class="del" onclick="deletePost(this);"
                                            data-id="{{ $post->id }}">削除</a>

                                        <form method="post"
                                            action="{{ action('Place\PostController@destroy', $post) }}"
                                            id="form_{{ $post->id }}">
                                            {{ csrf_field() }}
                                            {{ method_field('delete') }}
                                        </form>
                                    </div>
                                @endif

                            </li>
                        @endif
                    @empty
                        <li class="post__item-empty">現在は {{ $place->name }} の口コミは投稿されていません。</li>
                    @endforelse
                </ul>
                @php
                    session_start();
                    $place_key = $_SESSION['place_key'] ? $_SESSION['place_key'] : 'all';
                @endphp

                <div class="post__item-btn">
                    <a href="{{ route('post.create', ['id' => $place->id]) }}">
                        <i class="fas fa-pen"></i>
                        <span>新規作成</span>
                    </a>
                </div>

                <div class="post__item-back">
                    <a href="{{ route('place.result', ['result' => $place_key]) }}">戻る</a>
                </div>

            </div>

        </div>
    </section>

@endsection


@section('script')
    <script src="{{ asset('js/paginathing.min.js') }}"></script>
    <script type="text/javascript">
        //pagenationの設定
        $(function() {
            $('#post_list').paginathing({ //親要素のclassを記述
                perPage: 12, //1ページあたりの表示件数
                prevText: '前へ', //1つ前のページへ移動するボタンのテキスト
                nextText: '次へ', //1つ次のページへ移動するボタンのテキスト
                activeClass: 'navi-active', //現在のページ番号に任意のclassを付与できます
                firstLast: false
            })
        });

        function postlike(post) {
            // CSRFトークンを取得
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            // Fetch APIでリクエストを送信
            fetch(`/api/like/${post}`, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": token,
                    },
                })
                .then((response) => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then((data) => {
                    if (data.success) {
                        let itemlike = document.getElementsByClassName(`post__item-like${post}`)[0];
                        itemlike.setAttribute('onclick', `likedestroy(${post})`);
                        itemlike.classList.add(`post__item-liked${post}`)
                        itemlike.classList.remove(`post__item-like${post}`);

                        let likecount = document.getElementsByClassName(`post__itemspan${post}`)[0].innerText;
                        likecount++;
                        document.getElementsByClassName(`post__itemspan${post}`)[0].innerText = likecount;

                    }
                })
                .catch((error) => {
                    console.error('Error:', error);
                });
        }

        function likedestroy(post) {

            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            // Fetch APIでリクエストを送信
            fetch(`/api/like/delete/${post}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token // LaravelのCSRFトークン
                    }
                })
                .then((response) => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then((data) => {
                    if (data.success) {

                        let itemlike = document.getElementsByClassName(`post__item-liked${post}`)[0];
                        itemlike.setAttribute('onclick', `postlike(${post})`);
                        itemlike.classList.add(`post__item-like${post}`);
                        itemlike.classList.remove(`post__item-liked${post}`)

                        let likecount = document.getElementsByClassName(`post__itemspan${post}`)[0].innerText;
                        likecount--;
                        document.getElementsByClassName(`post__itemspan${post}`)[0].innerText = likecount;
                    }
                })
                .catch((error) => {
                    console.error('Error:', error);
                });


        }
    </script>

@endsection
