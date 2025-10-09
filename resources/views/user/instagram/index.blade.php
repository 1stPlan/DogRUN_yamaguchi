@extends('user.layouts.app_user')
@section('title', 'DogRUN - 山口県ドッグラン検索・情報サイト')

@section('description',
    '山口県内のドッグラン情報をどこよりも詳しく掲載！施設の特徴や利用料金、アクセス情報から、ユーザーの評価やレビューまで、愛犬とのお出かけに役立つリアルな情報が満載です。山口県のペットライフをもっと充実させたい方におすすめのドッグラン情報サイト')

@section('keywords', '山口県,ドッグラン,山口市,防府市,宇部市,下関市,山口ドッグラン,yamaguchi,dogrun,ペット,犬,お出かけ')

@section('h1')
    <h1 class="sr-only">DogRUN - 山口県ドッグラン検索・情報サイト</h1>
@endsection

@section('meta')
    <!-- Structured Data -->
    <script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "WebSite",
  "name": "DogRUN",
  "description": "山口県内のドッグラン情報をどこよりも詳しく掲載！施設の特徴や利用料金、アクセス情報から、ユーザーの評価やレビューまで、愛犬とのお出かけに役立つリアルな情報が満載です。",
  "url": "{{ url('/') }}",
  "potentialAction": {
    "@type": "SearchAction",
    "target": "{{ url('/user/place') }}",
    "query-input": "required name=search_term_string"
  },
  "publisher": {
    "@type": "Organization",
    "name": "DogRUN",
    "url": "{{ url('/') }}"
  }
}
</script>
@endsection

@section('css')
@endsection

@section('script')
@endsection

@section('content')

    <div class="instagram">

        <div class="instagram__page_header">
            <h3 class="instagram__page_title">DOG INSTAGRAM</h3>
            <span class="instagram__page_exp">【 Instagram投稿 】</span>
        </div>

        <!-- Instagram投稿セクション -->
        @if ($data && $data->count() > 0)
            <div class="instagram__inner">
                <div class="instagram__content">
                    <div class="instagram__grid">
                        @foreach ($data as $post)
                            <div class="instagram__item">
                                @if (isset($post['media_url']))
                                    <div class="instagram__image">
                                        <img src="{{ $post['media_url'] }}" alt="Instagram投稿" loading="lazy">
                                    </div>
                                @endif
                                @if (isset($post['caption']))
                                    <div class="instagram__caption">
                                        <p>{{ Str::limit($post['caption'], 100) }}</p>
                                    </div>
                                @endif
                                @if (isset($post['permalink']))
                                    <div class="instagram__link">
                                        <a href="{{ $post['permalink'] }}" target="_blank" rel="noopener noreferrer">
                                            Instagramで見る
                                        </a>
                                    </div>
                                @endif
                                @if (isset($post['timestamp']))
                                    <div class="instagram__date">
                                        <small>{{ \Carbon\Carbon::parse($post['timestamp'])->format('Y年m月d日') }}</small>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif

        <div class="instagram__back-button">
            <a href="{{ route('top') }}" class="">戻る</a>
        </div>

    @endsection
