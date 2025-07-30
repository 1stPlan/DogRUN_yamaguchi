import './bootstrap';

// jQueryが既にレイアウトファイルで読み込まれているため、グローバル設定のみ
window.$ = window.jQuery = jQuery;

// 必要なライブラリをインポート（管理画面専用）
import 'footable';
import 'slick-carousel';

// jQueryが利用可能になるまで待つ
function initAdmin() {
    if (typeof $ === 'undefined') {
        setTimeout(initAdmin, 100);
        return;
    }

    // datetimepickerをCDNから読み込み
    if (typeof $.datetimepicker === 'undefined') {
        const script = document.createElement('script');
        script.src = 'https://cdn.jsdelivr.net/npm/jquery-datetimepicker@2.5.20/build/jquery.datetimepicker.full.min.js';
        script.onload = function() {
            // datetimepicker読み込み完了後、管理者用のJSファイルをインポート
            import('./admin/app.js');
            import('./admin/button.js');
        };
        document.head.appendChild(script);
    } else {
        // datetimepickerが既に読み込まれている場合
        import('./admin/app.js');
        import('./admin/button.js');
    }
}

// DOMContentLoadedを待ってから初期化を開始
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initAdmin);
} else {
    initAdmin();
}
