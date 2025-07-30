<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="shortcut icon" href="{{ asset('/favicon.ico') }}" type="image/x-icon">
    <link rel="apple-touch-icon" href="{{ asset('/favicon.png') }}" sizes="180x180">
    <link rel="icon" type="image/png" href="{{ asset('/favicon.png') }}" sizes="192x192">

    <title>@yield('title', 'DogRUN - 山口県ドッグラン検索・情報サイト')</title>

    <!-- SEO Meta Tags -->
    <meta name="description" content="@yield('description', '山口県内のドッグラン情報をどこよりも詳しく掲載！施設の特徴や利用料金、アクセス情報から、ユーザーの評価やレビューまで、愛犬とのお出かけに役立つリアルな情報が満載です。山口県のペットライフをもっと充実させたい方におすすめのドッグラン情報サイト')">
    <meta name="keywords" content="@yield('keywords', '山口県,ドッグラン,山口市,防府市,宇部市,下関市,山口ドッグラン,yamaguchi,dogrun,ペット,犬,お出かけ')">
    <meta name="author" content="DogRUN">
    <meta name="robots" content="index, follow">
    <meta name="language" content="ja">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('og_title', 'DogRUN - 山口県ドッグラン検索・情報サイト')">
    <meta property="og:description" content="@yield('og_description', '山口県内のドッグラン情報をどこよりも詳しく掲載！施設の特徴や利用料金、アクセス情報から、ユーザーの評価やレビューまで、愛犬とのお出かけに役立つリアルな情報が満載です。')">
    <meta property="og:image" content="@yield('og_image', asset('/images/og-image.jpg'))">
    <meta property="og:site_name" content="DogRUN">
    <meta property="og:locale" content="ja_JP">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="@yield('twitter_title', 'DogRUN - 山口県ドッグラン検索・情報サイト')">
    <meta property="twitter:description" content="@yield('twitter_description', '山口県内のドッグラン情報をどこよりも詳しく掲載！施設の特徴や利用料金、アクセス情報から、ユーザーの評価やレビューまで、愛犬とのお出かけに役立つリアルな情報が満載です。')">
    <meta property="twitter:image" content="@yield('twitter_image', asset('/images/og-image.jpg'))">

    <!-- Canonical URL -->
    <link rel="canonical" href="{{ url()->current() }}">

    <!-- Sitemap -->
    <link rel="sitemap" type="application/xml" title="Sitemap" href="{{ url('/sitemap.xml') }}">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    @yield('meta')

    <?php
    $url = $_SERVER['REQUEST_URI'];
    
    // 直接一致するパス
    $exactUrls = ['/', '/login', '/register', '/user/setting/withdraw'];
    
    // 部分一致でチェックしたいパターン
    $patternUrls = ['/email/verify', '/password/reset'];
    
    ?>

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css"
        integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">

    <!-- SIMPLE LINE ICONS-->
    <link rel="stylesheet" href="{{ asset('vendor/simple-line-icons/css/simple-line-icons.css') }}">
    <!-- ANIMATE.CSS-->
    <link rel="stylesheet" href="{{ asset('vendor/animate.css/animate.css') }}">
    <!-- WHIRL (spinners)-->
    <link rel="stylesheet" href="{{ asset('vendor/whirl/dist/whirl.css') }}">


    <!-- =============== BOOTSTRAP STYLES ===============-->

    <!-- app -->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">

    <!-- style -->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">

    <!-- slick -->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/slick/slick.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/slick/slider.css') }}">

    <!--jQuery UI CSS-->
    <link rel="stylesheet" href="{{ asset('vendor/components-jqueryui/themes/smoothness/jquery-ui.css') }}">
    <!--datetimepicker CSS-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/jquery-datetimepicker@2.5.20/jquery.datetimepicker.css">


    @if (Config::get('app.env') == 'production')
        <!-- Google tag (gtag.js) -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-Z7338FBMBG"></script>
        <script>
            window.dataLayer = window.dataLayer || [];

            function gtag() {
                dataLayer.push(arguments);
            }
            gtag('js', new Date());

            gtag('config', 'G-Z7338FBMBG');
        </script>
    @endif

    @if (Config::get('app.env') == 'production')
        <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-9763272188223026"
            crossorigin="anonymous"></script>
    @endif

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>

    <!-- 各ページのCSS読み込み -->
    @yield('css')
</head>

<body>

    <!-- H1タグ管理 -->
    @yield('h1')


    <div id="header">
        @component('user.components.header')
        @endcomponent
    </div>

    <main id="content">
        @yield('content')
    </main>

    <div id="footer">
        @component('user.components.footer')
            @slot('')
            @endslot
        @endcomponent
    </div>


    <!-- =============== APP SCRIPTS ===============-->

    <!-- datetimepicker -->
    <script src="{{ asset('vendor/components-jqueryui/jquery-ui.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-datetimepicker@2.5.20/build/jquery.datetimepicker.full.min.js">
    </script>


    <!-- <script src="{{ asset('js/dogRun.js') }}"></script> -->
    <script src="{{ asset('js/main.js') }}"></script>
    <script src="{{ asset('js/bubblyButton.js') }}"></script>

    <!-- 各ページのJS読み込み -->
    @yield('script')

</body>

</html>
