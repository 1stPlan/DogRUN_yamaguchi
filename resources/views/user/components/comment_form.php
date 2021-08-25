<section class="comment_form">
  <div class="comment_form__circle-spase">
    <div class="comment_form__circle" id="form_circle">
      <span class="comment_form__circle-span"></span>
    </div>
  </div>
  <div class="comment_form__inner">

    <form class="comment_form__form" method="post" action="{{ action('User\CommentController@store', $post) }}">
      {{ csrf_field() }}
      <input class="comment_form__input" type="text" name="body" placeholder="" value="{{ old('body') }}">
      @if ($errors->has('body'))
      <span class="error">{{ $errors->first('body') }}</span>
      @endif
      <input class="comment_form__submit" type="submit" value="コメント">
    </form>

  </div>
</section>