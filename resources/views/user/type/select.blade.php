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


<div class="select">
  <div class="select__inner">


    <div class="select__cont">
      <h2 class="select__ttl">タイプ診断</h2>

      <div class="select__question">
        <p class="select__question-ttl">質問に答えてあなたのタイプを診断します。当てはまる項目を選択して進んでください。</p>
        <div class="select__question-txt">
          <h5>質問</h5>
          <p>{{ $question_text }}</p>
        </div>
      </div>


      <div class="select__answer">

        @if (count($outputQuestions))
        @foreach($outputQuestions as $index => $question)

        <a href="{{ route('user.select.type', ['setid' => $question['question_set_id'], 'nextid' => $question['next_text'] ]) }}"
          class="select__cont-btn btn">{{ $question['question'] }}</a>

        @endforeach
        @endif

      </div>
    </div>

  </div>
</div>
@endsection
