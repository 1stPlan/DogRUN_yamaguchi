@extends('user.layouts.app_user')
@section('title', 'DogRUN | タイプ診断')

@section('meta')
@endsection


@section('css')
<link rel="stylesheet" href="{{ asset('css/page/user/select.css') }}">
@endsection

@section('js')
@endsection

@section('content')

<div class="select_comp">
    <div class="select_comp__inner">

        <div class="select_comp__cont">
            <h2 class="select_comp__ttl">わんちゃん診断</h2>
            <p class="select_comp__cont-exp">あなたに合うタイプが見つかりました!!　<span>是非参考にしてみてください。</span></p>

            <div class="select_comp__decision">
                <div class="select_comp__decision-txt">
                    あなたの診断タイプは
                </div>
                <div class="select_comp__decision-box">
                    <div class="select_comp__decision-name">
                        <h3>{{ $outputQuestion->name }}</h3>
                    </div>
                    <div class="select_comp__decision-img">
                        <img src="{{ asset('images/question/' . $outputQuestion->img_url . '.jpg') }}" alt=""
                            width="100%">
                    </div>
                    <div class="select_comp__decision-reason">
                        <h5>理由</h5>
                        <p>{{ $outputQuestion->reason }}</p>
                    </div>
                    <div class="select_comp__decision-features">
                        <h5>特徴</h5>
                        <p>{{ $outputQuestion->features }}</p>
                    </div>
                </div>
            </div>

            <div class="select_comp__cont-btn-box">
                <a href="{{ route('user.type') }}" class="select_comp__cont-btn btn">戻る</a>
            </div>

        </div>




    </div>
</div>
</div>

@endsection