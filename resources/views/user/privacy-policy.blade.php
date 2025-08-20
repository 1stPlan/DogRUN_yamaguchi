@extends('user.layouts.app_user')
@section('title', 'プライバシーポリシー - DogRUN')

@section('description', 'DogRUNのプライバシーポリシーです。お客様の個人情報の取り扱いについて詳しく説明しています。')

@section('content')
<div class="privacy-policy">
    <div class="privacy-policy__inner">
        <h1 class="privacy-policy__title">プライバシーポリシー</h1>
        
        <div class="privacy-policy__content">
            <section class="privacy-policy__section">
                <h2>1. 個人情報の収集について</h2>
                <p>当サイトでは、お客様の個人情報を適切に収集、利用、管理することをお約束いたします。個人情報の取り扱いについて、以下のとおりプライバシーポリシーを定めます。</p>
            </section>

            <section class="privacy-policy__section">
                <h2>2. 収集する個人情報の種類</h2>
                <p>当サイトで収集する個人情報は以下の通りです：</p>
                <ul>
                    <li>氏名</li>
                    <li>メールアドレス</li>
                    <li>その他、お問い合わせフォームで入力いただく情報</li>
                </ul>
            </section>

            <section class="privacy-policy__section">
                <h2>3. 個人情報の利用目的</h2>
                <p>収集した個人情報は、以下の目的で利用いたします：</p>
                <ul>
                    <li>お問い合わせへの回答</li>
                    <li>サービスの提供・改善</li>
                    <li>お客様への情報提供</li>
                </ul>
            </section>

            <section class="privacy-policy__section">
                <h2>4. 個人情報の管理</h2>
                <p>お客様の個人情報を正確かつ最新の状態に保ち、個人情報の漏洩、滅失、き損の防止その他の個人情報の安全管理のために必要かつ適切な措置を講じます。</p>
            </section>

            <section class="privacy-policy__section">
                <h2>5. 個人情報の第三者提供</h2>
                <p>お客様の個人情報を、お客様の同意を得ることなく、第三者に提供することはありません。ただし、法令に基づき開示することが必要である場合を除きます。</p>
            </section>

            <section class="privacy-policy__section">
                <h2>6. 個人情報の開示・訂正・利用停止</h2>
                <p>お客様ご本人からの個人情報の開示、訂正、利用停止のご要望に対しては、法令に基づき適切に対応いたします。</p>
            </section>

            <section class="privacy-policy__section">
                <h2>7. クッキー（Cookie）の使用について</h2>
                <p>当サイトでは、お客様により良いサービスを提供するために、クッキーを使用することがあります。クッキーの使用を望まない場合は、ブラウザの設定でクッキーを無効にすることができます。</p>
            </section>

            <section class="privacy-policy__section">
                <h2>8. Google広告について</h2>
                <p>当サイトでは、第三者配信の広告サービス（Googleアドセンス）を利用しています。広告配信事業者は、お客様の興味に応じた広告を表示するために、Cookie（クッキー）を使用することがあります。</p>
                <p>お客様は、<a href="https://www.google.com/settings/ads" target="_blank">Google広告設定</a>で、このような広告配信事業者によるCookie使用を無効にすることができます。</p>
            </section>

            <section class="privacy-policy__section">
                <h2>9. アクセス解析ツールについて</h2>
                <p>当サイトでは、Googleによるアクセス解析ツール「Googleアナリティクス」を使用しています。このGoogleアナリティクスは、データの収集のためにCookieを使用しています。このデータは匿名で収集されており、個人を特定するものではありません。</p>
            </section>

            <section class="privacy-policy__section">
                <h2>10. プライバシーポリシーの変更について</h2>
                <p>当サイトは、必要に応じて、このプライバシーポリシーの内容を変更することがあります。その場合、変更内容を当サイト上でお知らせいたします。</p>
            </section>

            <section class="privacy-policy__section">
                <h2>11. お問い合わせ</h2>
                <p>プライバシーポリシーに関するお問い合わせは、<a href="{{ route('user.contact') }}">お問い合わせフォーム</a>からお願いいたします。</p>
            </section>

            <div class="privacy-policy__footer">
                <p>制定日：2024年1月1日</p>
                <p>最終更新日：2024年12月19日</p>
            </div>
        </div>
    </div>
</div>
@endsection 