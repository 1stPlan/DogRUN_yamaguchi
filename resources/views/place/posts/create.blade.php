@extends('user.layouts.app_user')
@section('title', 'DogRUN | 口コミ作成')

@section('meta')
@endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/page/user/post/post.css') }}">
@endsection

@section('content')

    <section class="post_create">

        <div class="post_create__inner">

            <div class="post_create__head">
                <div class="post_create__pic">
                    <img src="{{ asset('storage/image/shop/' . $place->id . '.jpg') }}" alt="">
                </div>
                <h3 class="post_create__title">{{ $place->name }} 口コミ</h3>
            </div>

            <div class="post_create__desc">
                他のユーザーの意見や体験をチェックできます。気になった内容には、評価を付けることが可能です。
            </div>

            <div class="post_create__cont">

                <form action="{{ route('post.store') }}" method="post" enctype="multipart/form-data">
                    {{ csrf_field() }}

                    <label class="post_create__form-label" for="tittle">タイトル</label>
                    <input type="text" class="post_create__form-tit" name="tittle" value="{{ old('tittle') }}"
                        placeholder="タイトルを記入">

                    <label class="post_create__form-label" for="body">本文</label>
                    <textarea class="post_create__form-body" name="body" placeholder="本文を入れてください" value="{{ old('body') }}"></textarea>

                    @if ($errors->has('body'))
                        <span class="error">{{ $errors->first('body') }}</span>
                    @endif

                    <label class="post_create__form-label" for="rating">評価</label>

                    <div class="post_create__form-rating">
                        <input class="post_create__form-rating-input" id="star5" name="rating" type="radio"
                            value="5">
                        <label class="post_create__form-rating-label" for="star5"><i class="fas fa-star"></i></label>

                        <input class="post_create__form-rating-input" id="star4" name="rating" type="radio"
                            value="4">
                        <label class="post_create__form-rating-label" for="star4"><i class="fas fa-star"></i></label>

                        <input class="post_create__form-rating-input" id="star3" name="rating" type="radio"
                            value="3">
                        <label class="post_create__form-rating-label" for="star3"><i class="fas fa-star"></i></label>

                        <input class="post_create__form-rating-input" id="star2" name="rating" type="radio"
                            value="2">
                        <label class="post_create__form-rating-label" for="star2"><i class="fas fa-star"></i></label>

                        <input class="post_create__form-rating-input" id="star1" name="rating" type="radio"
                            value="1">
                        <label class="post_create__form-rating-label" for="star1"><i class="fas fa-star"></i></label>
                    </div>

                    <label class="post_create__form-label" for="name">ニックネーム</label>
                    @if ($user)
                        <input type="text" class="post_create__form-name" name="name" value="{{ $user->name }}"
                            autocomplete="name" placeholder="ニックネームを記入">
                    @else
                        <input type="text" class="post_create__form-name" name="name" value="{{ old('name') }}"
                            autocomplete="name" placeholder="ニックネームを記入">
                    @endif
                    <input type="hidden" name="place_id" value="{{ $place->id }}">
                    <input class="post_create__form-btn" type="submit" value="作成">
                </form>

                <div class="post_create__back-btn">
                    <a href="{{ route('post', $place->id) }}">戻る</a>
                </div>

            </div>

        </div>

    </section>

@endsection
