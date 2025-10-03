/**
 * 現在地検索機能システム
 *
 * このファイルは以下の主要機能を提供します：
 * 1. 現在地からのドッグラン検索
 * 2. 位置情報の取得とエラーハンドリング
 * 3. 距離計算とソート
 * 4. 検索結果のカード形式表示
 * 5. ボタン状態の適切な管理
 */

// 現在地検索機能
class LocationSearch {
    constructor() {
        this.host = location.origin;
        // 全ドッグランデータを1つのAPIエンドポイントで取得
        this.urls = [this.host + "/api/place/all"];
        this.ratingUrl = this.host + "/api/place/rating";
        this.isProcessing = false; // 二重実行防止
        this.init();
    }

    /**
     * 初期化処理
     */
    init() {
        this.bindEvents();
    }

    /**
     * イベントリスナーの設定
     */
    bindEvents() {
        const searchButton = document.querySelector('.top-search__button .btn');
        if (searchButton) {
            searchButton.addEventListener('click', () => this.getCurrentLocation());
        }
    }

    /**
     * 現在地から検索を実行
     * 位置情報を取得し、近いドッグランを表示する
     */
    async getCurrentLocation() {
        // 二重起動防止
        if (this.isProcessing) {
            console.log('現在地検索は処理中のためスキップしました');
            return;
        }
        this.isProcessing = true;

        const button = document.querySelector('.top-search__button .btn');
        if (!button) {
            console.error('検索ボタンが見つかりません');
            this.isProcessing = false;
            return;
        }

        const originalText = button.innerHTML;
        const originalDisabled = button.disabled;

        try {
            // ボタンをローディング状態に
            button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> 位置情報を取得中...';
            button.disabled = true;

            // 位置情報を取得（タイムアウト付き）
            const position = await Promise.race([
                this.getGeolocation(),
                new Promise((_, reject) => setTimeout(() => reject(new Error('位置情報の取得がタイムアウトしました。')), 15000))
            ]);

            // ドッグランデータを取得
            const results = await this.fetchURLs(this.urls);
            const ratings = await this.fetchRatings(this.ratingUrl);

            if (results.length > 0) {
                // 現在地から近いドッグランを表示
                this.displayNearbyDogruns(position, results, ratings);
            } else {
                this.showError('ドッグランデータの取得に失敗しました。');
            }
        } catch (error) {
            console.error('Error in getCurrentLocation:', error);

            // エラーの種類に応じてメッセージを変更
            let errorMessage = '位置情報の取得に失敗しました。';
            if (error.code === 1) {
                errorMessage = '位置情報の取得が拒否されました。ブラウザの設定を確認してください。';
            } else if (error.code === 2) {
                errorMessage = '位置情報を取得できませんでした。ネットワーク接続を確認してください。';
            } else if (error.code === 3) {
                errorMessage = '位置情報の取得がタイムアウトしました。';
            } else if (error.message && error.message.includes('タイムアウト')) {
                errorMessage = '位置情報の取得がタイムアウトしました。しばらく待ってから再試行してください。';
            }
            this.showError(errorMessage);
        } finally {
            // フラグ解除とボタンを確実に元の状態に戻す
            this.isProcessing = false;
            this.resetButtonState(button, originalText, originalDisabled);
        }
    }

    /**
     * ボタンの状態を確実にリセットする
     */
    resetButtonState(button, originalText, originalDisabled) {
        if (!button) return;
        try {
            button.innerHTML = originalText;
            button.disabled = originalDisabled;
            console.log('ボタンの状態を元に戻しました');
        } catch (error) {
            console.error('ボタンの状態リセットに失敗:', error);
            try {
                button.innerHTML = '現在地から検索';
                button.disabled = false;
                console.log('フォールバックでボタンの状態をリセットしました');
            } catch (fallbackError) {
                console.error('フォールバックリセットも失敗:', fallbackError);
            }
        }
    }

    /**
     * 位置情報を取得する
     * @returns {Promise} 位置情報オブジェクト
     */
    getGeolocation() {
        return new Promise((resolve, reject) => {
            if (!navigator.geolocation) {
                reject(new Error('Geolocation is not supported by this browser.'));
                return;
            }

            // タイムアウト処理を追加
            const timeoutId = setTimeout(() => {
                reject(new Error('位置情報の取得がタイムアウトしました。'));
            }, 15000); // 15秒でタイムアウト

            navigator.geolocation.getCurrentPosition(
                position => {
                    clearTimeout(timeoutId);
                    resolve(position);
                },
                error => {
                    clearTimeout(timeoutId);
                    reject(error);
                },
                {
                    enableHighAccuracy: true,  // 高精度な位置情報を要求
                    timeout: 10000,            // 10秒でタイムアウト
                    maximumAge: 600000         // 10分間有効な位置情報を使用
                }
            );
        });
    }

    /**
     * 複数のURLからデータを並行取得
     * @param {Array} urls - 取得対象のURL配列
     * @returns {Array} 取得したデータの配列
     */
    async fetchURLs(urls) {
        try {
            const results = await Promise.all(
                urls.map(url =>
                    fetch(url)
                        .then(response => response.json())
                        .catch(e => {
                            console.error(`Error fetching ${url}:`, e);
                            return null;
                        })
                )
            );
            return results.filter(result => result !== null);
        } catch (error) {
            console.error("Error in fetchURLs:", error);
            return [];
        }
    }

    /**
     * 評価データを取得
     * @param {string} ratingUrl - 評価APIのURL
     * @returns {Array} 評価データの配列
     */
    async fetchRatings(ratingUrl) {
        try {
            const response = await fetch(ratingUrl);
            return await response.json();
        } catch (e) {
            console.error("Error in fetchRatings:", e);
            return [];
        }
    }

    /**
     * 現在地から近いドッグランを表示
     * @param {Object} position - 位置情報オブジェクト
     * @param {Array} results - ドッグランデータ
     * @param {Array} ratings - 評価データ
     */
    displayNearbyDogruns(position, results, ratings) {
        const coords = position.coords;
        // allエンドポイントから取得したデータを直接使用
        const dataList = results[0];
        const ratingList = ratings.flatMap(item => item);

        // 距離を計算してソート
        dataList.forEach(data => {
            data.distance = this.getDistance(
                data.lat,
                data.lng,
                coords.latitude,
                coords.longitude,
                0
            ) / 1000; // メートルからキロメートルに変換
        });

        // 距離順でソート（近い順）
        dataList.sort((a, b) => a.distance - b.distance);

        // 近くのドッグランを表示（上位3件）
        const nearbyDogruns = dataList.slice(0, 3);
        this.displayNearbyList(nearbyDogruns, ratingList);

        // 結果セクションを表示
        const resultSection = document.getElementById('location-result');
        if (resultSection) {
            resultSection.style.display = 'block';
            resultSection.scrollIntoView({ behavior: 'smooth' });
        }
    }

    /**
     * 近くのドッグランリストを表示
     * @param {Array} dogruns - ドッグランデータ
     * @param {Array} ratings - 評価データ
     */
    displayNearbyList(dogruns, ratings) {
        const nearbyContainer = document.getElementById('nearby-dogruns');
        if (!nearbyContainer) return;

        let html = '';
        // 最大3つまで表示（現在は1つに制限）
        const displayCount = Math.min(dogruns.length, 2);
        for (let i = 0; i < displayCount; i++) {
            const dogrun = dogruns[i];
            const rating = this.getRating(dogrun.id, ratings);
            html += this.createDogrunCard(dogrun, rating, i + 1);
        }

        nearbyContainer.innerHTML = html;
        // 閉じるボタンのイベントリスナーを設定
        this.bindCloseButtonEvents();
    }

    /**
     * 特定のドッグランの評価を取得
     * @param {number} dogrunId - ドッグランのID
     * @param {Array} ratings - 評価データの配列
     * @returns {Object} 平均評価と件数
     */
    getRating(dogrunId, ratings) {
        const dogrunRatings = ratings.filter(rating => rating.place == dogrunId);
        if (dogrunRatings.length === 0) return { average: 0, count: 0 };

        const sum = dogrunRatings.reduce((acc, rating) => acc + rating.rating, 0);
        return {
            average: sum / dogrunRatings.length,
            count: dogrunRatings.length
        };
    }

    /**
     * ドッグランカードのHTMLを生成
     * @param {Object} dogrun - ドッグランデータ
     * @param {Object} rating - 評価データ
     * @param {number} rank - 順位
     * @returns {string} 生成されたHTML
     */
    createDogrunCard(dogrun, rating, rank) {
        const stars = this.createStarRating(rating.average);

        return `
            <a class="nearby-dogrun-card" href="${dogrun.url}" target="_blank">

                <div class="nearby-dogrun-card__image">
                   <img src="${
                     this.host + '/storage/image/shop/' + dogrun.id + '.jpg'
                   }" alt="" width="100%">
                </div>

                <div class="nearby-dogrun-card__content">
                    <div class="nearby-dogrun-card__header">
                        <span>${rank}</span>
                        <h4 class="nearby-dogrun-card__title">${dogrun.name}</h4>
                    </div>

                    <ul class="nearby-dogrun-card__list">
                        <li>距離: ${dogrun.distance.toFixed(2)}km </li>
                        <li>営業時間: ${dogrun.time}</li>
                        <li> 住所: ${dogrun.address}</li>
                        <li>料金: ${dogrun.price}</li>
                    </ul>

                    <div class="nearby-dogrun-card__footer">
                        <div class="nearby-dogrun-card__point">
                            評価: ${stars} (${rating.count}件)
                        </div>
                    </div>
                </div>
            </div>
        `;
    }

    /**
     * 閉じるボタンのHTMLを生成（現在は非表示）
     * @returns {string} 閉じるボタンのHTML
     */
    createCloseButton() {
        return `
            <div class="close-button-container">
                <button id="close-nearby-list">
                    ✕ 閉じる
                </button>
            </div>
        `;
    }

    /**
     * 閉じるボタンのイベントリスナーを設定
     */
    bindCloseButtonEvents() {
        const closeButton = document.getElementById('close-nearby-list');
        if (closeButton) {
            closeButton.addEventListener('click', () => {
                this.closeNearbyList();
            });
        }
    }

    /**
     * 近くのドッグランリストを閉じる
     */
    closeNearbyList() {
        // 近くのドッグランリストを完全に非表示にする
        const locationResult = document.getElementById('location-result');
        if (locationResult) {
            locationResult.style.display = 'none';
        }
        // 念のため、内部のコンテンツもクリア
        const nearbyContainer = document.getElementById('nearby-dogruns');
        if (nearbyContainer) {
            nearbyContainer.innerHTML = '';
        }
    }

    /**
     * 星評価のHTMLを生成
     * @param {number} rating - 評価値（0-5）
     * @returns {string} 星評価のHTML
     */
    createStarRating(rating) {
        const fullStars = Math.floor(rating);
        const hasHalfStar = rating % 1 >= 0.5;
        const emptyStars = 5 - fullStars - (hasHalfStar ? 1 : 0);

        let stars = '';
        for (let i = 0; i < fullStars; i++) {
            stars += '<i class="fas fa-star" style="color: #f39c12;"></i>';
        }
        if (hasHalfStar) {
            stars += '<i class="fas fa-star-half-alt" style="color: #f39c12;"></i>';
        }
        for (let i = 0; i < emptyStars; i++) {
            stars += '<i class="far fa-star" style="color: #bdc3c7;"></i>';
        }

        return stars;
    }

    /**
     * 2点間の緯度経度から距離を取得
     * 測地線航海算法を使用して距離を算出する。
     * @param {number} lat1 - 緯度1
     * @param {number} lng1 - 経度1
     * @param {number} lat2 - 緯度2
     * @param {number} lng2 - 経度2
     * @param {number} precision - 小数点以下の桁数(べき乗で算出精度を指定)
     * @returns {number} 距離（メートル）
     */
    getDistance(lat1, lng1, lat2, lng2, precision) {
        let distance = 0;

        // 同じ座標の場合は0を返す
        if (Math.abs(lat1 - lat2) < 0.00001 && Math.abs(lng1 - lng2) < 0.00001) {
            distance = 0;
        } else {
            // ラジアンに変換
            lat1 = (lat1 * Math.PI) / 180;
            lng1 = (lng1 * Math.PI) / 180;
            lat2 = (lat2 * Math.PI) / 180;
            lng2 = (lng2 * Math.PI) / 180;

            // 地球の楕円体パラメータ（GRS80）
            const A = 6378140; // 長半径（メートル）
            const B = 6356755; // 短半径（メートル）
            const F = (A - B) / A; // 扁平率

            const P1 = Math.atan((B / A) * Math.tan(lat1));
            const P2 = Math.atan((B / A) * Math.tan(lat2));

            const X = Math.acos(
                Math.sin(P1) * Math.sin(P2) +
                Math.cos(P1) * Math.cos(P2) * Math.cos(lng1 - lng2)
            );

            // 楕円体補正項
            const L = (F / 8) * (
                ((Math.sin(X) - X) * Math.pow(Math.sin(P1) + Math.sin(P2), 2)) /
                Math.pow(Math.cos(X / 2), 2) -
                ((Math.sin(X) - X) * Math.pow(Math.sin(P1) - Math.sin(P2), 2)) /
                Math.pow(Math.sin(X), 2)
            );

            distance = A * (X + L);

            // 精度を指定して丸める
            const decimal_no = Math.pow(10, precision);
            distance = Math.round((decimal_no * distance) / 1) / decimal_no;
        }
        return distance;
    }

    /**
     * エラーメッセージを表示
     * @param {string} message - 表示するエラーメッセージ
     */
    showError(message) {
        const resultSection = document.getElementById('location-result');
        if (resultSection) {
            resultSection.innerHTML = `
                <div style="
                    background: #f8d7da;
                    color: #721c24;
                    padding: 20px;
                    border-radius: 10px;
                    border: 1px solid #f5c6cb;
                    text-align: center;
                ">
                    <i class="fas fa-exclamation-triangle" style="margin-right: 10px;"></i>
                    ${message}
                </div>
            `;
            resultSection.style.display = 'block';
        }
    }
}

// ページ読み込み完了後に初期化（重複初期化防止）
(function () {
    if (window.__locationSearchInitialized) return;
    window.__locationSearchInitialized = true;
    document.addEventListener('DOMContentLoaded', () => {
        new LocationSearch();
    });
})();