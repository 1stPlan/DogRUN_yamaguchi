<header class="header">
    <div class="header__list">
        <div class="header__logo">
            <div class="header__logo-img">
                <img src="{{ asset('/images/icon.png') }}" alt="logo" width="100%">
            </div>
            <a class="header__logo-text" href="{{ route('top') }}">
                <p>山口県ドッグラン<br>検索・情報</p>
                <h1>DogRun</h1>
            </a>
        </div>

        <div class="header__btn--pc">

            @if (Auth::check())
                <a class="header__btn-link--1 bubbly-button" href="{{ route('user.setting') }}">
                    Mypage
                </a>
                <a class="header__btn-link--2 bubbly-button" href=""
                    onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                    Logout
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            @else
                <a class="header__btn-link--2 bubbly-button" href="{{ route('login') }}">
                    login
                </a>
            @endif

        </div>

        <div class="header__menu">
            <label>
                <input type="checkbox" name="check" id='cross_menu'>
                <svg viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="50" cy="50" r="30" />
                    <path class="line--1" d="M0 70l28-28c2-2 2-2 7-2h64" />
                    <path class="line--2" d="M0 50h99" />
                    <path class="line--3" d="M0 30l28 28c2 2 2 2 7 2h64" />
                </svg>
            </label>
            <p>Menu</p>
        </div>
    </div>
</header>

<nav id="header-nav" class="header-nav">

    <div class="header__btn--sp">

        @if (Auth::check())
            <a class="header__btn-link--1 bubbly-button" href="{{ route('user.setting') }}">
                Mypage
            </a>
            <a class="header__btn-link--2 bubbly-button" href=""
                onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                Logout
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        @else
            <a class="header__btn-link--2 bubbly-button" href="{{ route('login') }}">
                login
            </a>
        @endif
    </div>

    <ul class="header-nav__list">
        <li class="header-nav__item">
            <a href="{{ route('top') }}">
                <div class="header-nav__thumbnail">
                    <img src="{{ asset('/images/dogrun.jpg') }}" alt="" width="100%">
                </div>
                <span>DogRun 検索</span>
            </a>
        </li>

        <li class="header-nav__item">
            <a href="{{ route('user.event') }}">
                <div class="header-nav__thumbnail">
                    <img src="{{ asset('/images/dogevent.jpg') }}" alt="" width="100%">
                </div>
                <span>わんちゃんイベント</span>
            </a>
        </li>


        {{--  <li class="header-nav__item">
            <a href="{{ route('user.type') }}">
                <div class="header-nav__thumbnail">
                    <img src="{{ asset('/images/dogdiagnosis.jpg') }}" alt="" width="100%">
                </div>
                <span>わんちゃん診断</span>
            </a>
        </li>  --}}

        <li class="header-nav__item">
            <a href="{{ route('user.food') }}">
                <div class="header-nav__thumbnail">
                    <img src="{{ asset('/images/dogfood.jpg') }}" alt="" width="100%">
                </div>
                <span>ご飯ランキング</span>
            </a>
        </li>

        <li class="header-nav__item">
            <a href="{{ route('user.instagram') }}">
                <div class="header-nav__thumbnail">
                    <img src="{{ asset('/images/instagram.jpg') }}" alt="" width="100%">
                </div>
                <span>Instagram</span>
            </a>
        </li>

        <li class="header-nav__item">
            <a href="{{ route('user.contact') }}">
                <div class="header-nav__thumbnail">
                    <img src="{{ asset('/images/contact.jpg') }}" alt="" width="100%">
                </div>
                <span>管理者DM</span>
            </a>
        </li>

    </ul>
</nav>
