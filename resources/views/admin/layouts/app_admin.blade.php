<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="icon" type="image/x-icon" href="favicon.ico">
    <title>DogRUN | 管理画面</title>
    <meta name="description" content="DogRUN 管理画面">
    <meta name="keywords" content="DogRUN">
    <meta name="root_url" content="{{ route('admin.root') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @yield('meta')

    <!-- =============== VENDOR STYLES ===============-->
    <!-- FONT AWESOME-->
    <link rel="stylesheet" href="{{ asset('vendor/@fortawesome/fontawesome-free/css/brands.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/@fortawesome/fontawesome-free/css/regular.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/@fortawesome/fontawesome-free/css/solid.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/@fortawesome/fontawesome-free/css/fontawesome.css') }}">
    <!-- SIMPLE LINE ICONS-->
    <link rel="stylesheet" href="{{ asset('vendor/simple-line-icons/css/simple-line-icons.css') }}">
    <!-- ANIMATE.CSS-->
    <link rel="stylesheet" href="{{ asset('vendor/animate.css/animate.css') }}">
    <!-- WHIRL (spinners)-->
    <!-- <link rel="stylesheet" href="{{ asset('vendor/whirl/dist/whirl.css') }}"> -->
    <!--jQuery UI CSS-->
    <link rel="stylesheet" href="{{ asset('vendor/components-jqueryui/themes/smoothness/jquery-ui.css') }}">
    <!--datetimepicker CSS-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/jquery-datetimepicker@2.5.20/jquery.datetimepicker.css">

    <!-- =============== BOOTSTRAP STYLES ===============-->

    @yield('css')
    <link href="{{ asset('css/admin/bootstrap.css') }}" rel="stylesheet">
    <link href="{{ asset('css/admin/app.css') }}" rel="stylesheet">
    <link id="autoloaded-stylesheet" rel="stylesheet" href="{{ asset('css/admin/theme-a.css') }}">

    <!-- =============== APP SCRIPTS ===============-->

    <!-- jQueryを最初に読み込み -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Scripts -->
    @vite(['resources/js/admin.js'])

    <!-- <script src="{{ asset('vendor/screenfull/dist/screenfull.js') }}"></script> -->
    <!-- i18next-->
    <script src="{{ asset('vendor/i18next/i18next.js') }}"></script>

    <!-- unique -->
    @yield('js')

</head>

<body>
    <div class="wrapper">
        <!-- top navbar-->

        @component('admin.components.header')
        @endcomponent

        @component('admin.components.sidebar_admin')
            @slot('firstLevel')
                @yield('sidebar_first_level_active')
            @endslot
        @endcomponent

        @yield('content')

        <footer class="footer-container">
            <span>&copy; 2024 - DogRUN</span>
        </footer>
    </div>
    <!-- =============== VENDOR SCRIPTS ===============-->
    <!-- MODERNIZR-->
    <script src="{{ asset('vendor/modernizr/modernizr.custom.js') }}"></script>
    <!-- STORAGE API-->
    <script src="{{ asset('vendor/js-storage/js.storage.js') }}"></script>
    <!-- i18next-->
    <script src="{{ asset('vendor/i18next/i18next.js') }}"></script>

    <!-- =============== PAGE VENDOR SCRIPTS ===============-->

    @yield('footer_js')
</body>

</html>
