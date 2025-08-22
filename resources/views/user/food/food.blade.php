@extends('user.layouts.app_user')
@section('title', 'DogRUN | 店舗一覧')

@section('css')
@endsection

@section('meta')
@endsection

@section('script')
    <script>
        // アマゾンアソシエイトタグをグローバル変数として設定
        window.AMAZON_ASSOCIATE_TAG = '{{ config('app.amazon_associate_tag') }}';
    </script>
    @vite('resources/js/components/dogFood.js')
@endsection

@section('content')

    <div class="food">

        <div class="food__page_header">
            <h3 class="food__page_title">DogFood</h3>
            <span class="food__page_exp">【売り上げランキング】</span>
        </div>

        <div class="food__content">
            <div id="loader" class="food__loader">読み込み中...</div>
            <div id="food__content_amazon" class="food__content_amazon">
            </div>
        </div>
        <div class="food__store-button">
            <a href="{{ route('top') }}" class="">戻る</a>
        </div>
    </div>

@endsection
