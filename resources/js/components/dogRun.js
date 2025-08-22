/**
 * ドッグラン検索・表示システム
 * 
 * このファイルは以下の主要機能を提供します：
 * 1. 全ドッグランデータの取得（allエンドポイント使用）
 * 2. 地域別・キーワード・サービス条件でのフィルタリング
 * 3. 評価・口コミ情報の表示
 * 4. 結果のHTML生成と表示
 * 
 * 注意：現在地検索機能はLocationSearchクラスで実装されています
 */

// URLパラメータとパスの取得
let params = new URLSearchParams(document.location.search);
let places = location.pathname
    .replace(/\/+$/, "")
    .split("/")
    .pop();
let host = location.origin;
let html = ""; // 生成されるHTMLの格納
let count = 0; // 検索結果件数の格納

// APIエンドポイントの定義（allエンドポイントで全データを取得）
const urls = [host + "/api/place/all"];
const ratingurl = host + "/api/place/rating";

// 対応地域の定義
const regions = [
    "yamaguchi",
    "shimonoseki",
    "houhu",
    "hagi",
    "syuunan",
    "ubeonoda",
    "iwakunihikari"
];

/**
 * 初期化処理
 */
function initDogRun() {
    // フォーム送信のイベントハンドラーを設定
    const searchForm = document.querySelector('.top-filter__checkbox form');
    if (searchForm) {
        searchForm.addEventListener('submit', handleFormSubmit);
        console.log('検索フォームのイベントハンドラーを設定しました');
    } else {
        console.log('検索フォームが見つかりません');
    }
}

/**
 * フォーム送信時の処理
 * @param {Event} event - フォーム送信イベント
 */
function handleFormSubmit(event) {
    event.preventDefault(); // デフォルトの送信を防止

    console.log('検索フォームが送信されました');

    // フォームデータを取得
    const formData = new FormData(event.target);
    const keyword = formData.get('keyword');
    const services1 = formData.get('services_1');
    const services2 = formData.get('services_2');
    const services3 = formData.get('services_3');

    // URLパラメータを構築
    const searchParams = new URLSearchParams();
    if (keyword) searchParams.set('keyword', keyword);
    if (services1) searchParams.set('services_1', services1);
    if (services2) searchParams.set('services_2', services2);
    if (services3) searchParams.set('services_3', services3);

    // 検索結果ページにリダイレクト
    const searchUrl = `${host}/place/all?${searchParams.toString()}`;
    window.location.href = searchUrl;
}

/**
 * 全ドッグランデータを取得する
 * @param {Array} urls - 取得対象のURL配列（現在はallエンドポイントのみ）
 * @returns {Array} 取得したデータの配列
 */
async function fetchURLs(urls) {
    try {
        // allエンドポイントから全データを取得
        const response = await fetch(urls[0]);
        const data = await response.json();
        return [data]; // 配列形式を維持して既存の処理との互換性を保つ
    } catch (error) {
        console.error("Error in fetchURLs:", error);
        return [];
    }
}

/**
 * 評価データを取得する
 * @param {string} ratingurl - 評価APIのURL
 * @returns {Array|null} 評価データの配列、エラー時はnull
 */
async function fetchRatings(ratingurl) {
    try {
        const response = await fetch(ratingurl);
        return await response.json();
    } catch (e) {
        console.error("Error in fetchRatings:", e);
        return null;
    }
}

/**
 * メイン処理：ドッグランデータの取得と表示
 */
async function dogrun() {
    const results = await fetchURLs(urls);
    const ratings = await fetchRatings(ratingurl);

    if (results.length > 0 && results[0] && Array.isArray(results[0])) {
        // allエンドポイントから取得したデータを直接使用
        const dataList = results[0];
        const ratingList = ratings ? ratings.flatMap(item => item) : [];

        // 検索条件に応じたデータ処理
        processSearchResults(dataList, ratingList);
    } else {
        console.error('ドッグランデータの取得に失敗しました');
        displayNoResults();
    }
}

/**
 * 検索条件に応じた結果処理
 * @param {Array} dataList - ドッグランデータ
 * @param {Array} ratingList - 評価データ
 */
function processSearchResults(dataList, ratingList) {
    if (places === "position") {
        // 現在地検索の場合はエラーメッセージを表示
        // 現在地検索はLocationSearchクラスで実装されているため
        alert("現在地検索は別のボタンから実行してください。");
        count = "0件";
        html = "";
    } else if (regions.includes(places)) {
        // 特定地域のドッグランのみ表示
        const filteredData = dataList.filter(data => data.tag === places);
        const html_count = generateHTML(filteredData, false, ratingList);
        html = html_count[0];
        count = `${html_count[1]}件`;
    } else if (params.get("keyword")) {
        // キーワード検索
        const keywords = get_search_keywords("keyword");
        if (keywords) {
            const jsonKeys = ["name", "address"];
            const index = keyword_search(dataList, keywords, jsonKeys);
            if (index.length > 0) {
                const searchResults = index.map(i => dataList[i]);
                const html_count = generateHTML(searchResults, false, ratingList);
                html = html_count[0];
                count = `${html_count[1]}件`;
            } else {
                displayNoResults();
                return;
            }
        } else {
            displayNoResults();
            return;
        }
    } else if (
        params.get("services_1") ||
        params.get("services_2") ||
        params.get("services_3")
    ) {
        // サービス条件でのフィルタリング
        const serviceFilteredData = serviceLists(dataList);
        const html_count = generateHTML(serviceFilteredData, false, ratingList);
        html = html_count[0];
        count = `${html_count[1]}件`;
    } else {
        // 全件表示
        const html_count = generateHTML(dataList, false, ratingList);
        html = html_count[0];
        count = `${html_count[1]}件`;
    }

    displayResults(html, count);
}

/**
 * 検索結果を画面に表示
 * @param {string} html - 生成されたHTML
 * @param {string} count - 件数
 */
function displayResults(html, count) {
    const resultCountElement = document.getElementById("js-result-count");
    const resultContentElement = document.getElementById("result__content");

    if (resultCountElement) {
        resultCountElement.insertAdjacentHTML("afterbegin", count);
    } else {
        console.debug("js-result-count 要素が見つかりません - 現在のページには存在しない可能性があります");
    }

    if (resultContentElement) {
        resultContentElement.insertAdjacentHTML("afterbegin", html);
    } else {
        console.debug("result__content 要素が見つかりません - 現在のページには存在しない可能性があります");
    }
}

/**
 * 検索結果がない場合の表示
 */
function displayNoResults() {
    alert("キーワードに一致する記事がありませんでした。");
    const noResultHTML = `
      <span>ご指定の検索条件に合う店舗が見つかりませんでした。</span>
      <span>大変お手数ですが、条件を変えて再度検索してください。</span>
    `;

    const noStoreElement = document.getElementById("resultNoStore");
    if (noStoreElement) {
        noStoreElement.insertAdjacentHTML("afterbegin", noResultHTML);
    } else {
        console.debug("resultNoStore 要素が見つかりません - 現在のページには存在しない可能性があります");
    }

    count = "0件";
    html = "";
}

/**
 * ドッグランデータからHTMLを生成
 * @param {Array} dataList - ドッグランデータ
 * @param {boolean} showDistance - 距離を表示するかどうか（現在地検索でない場合は常にfalse）
 * @param {Array} ratingList - 評価データ
 * @returns {Array} [HTML文字列, 件数]
 */
function generateHTML(dataList, showDistance, ratingList) {
    let html = "";
    let rating_count = 0;
    let rating_sum = 0;
    let rating_ave = 0;

    dataList.forEach(data => {
        // 各ドッグランの評価を計算
        for (let i = 0; i < ratingList.length; i++) {
            if (data["id"] == ratingList[i]["place"]) {
                rating_sum += ratingList[i]["rating"];
                rating_count++;
            }
        }
        rating_ave = rating_sum / rating_count;

        // NaNチェック（評価がない場合）
        if (isNaN(rating_ave)) {
            rating_ave = 0;
        }

        // 個別のドッグランHTMLを生成
        html += createStoreHTML(data, false, rating_ave, rating_count); // showDistanceは常にfalse

        // 変数をリセット
        rating_count = 0;
        rating_sum = 0;
        rating_ave = 0;
    });

    return [html, dataList.length];
}

/**
 * 個別のドッグランカードHTMLを生成
 * @param {Object} data - ドッグランデータ
 * @param {boolean} showDistance - 距離を表示するかどうか（現在地検索でない場合は常にfalse）
 * @param {number} rating_ave - 平均評価
 * @param {number} rating_count - 評価件数
 * @returns {string} 生成されたHTML
 */
function createStoreHTML(data, showDistance, rating_ave, rating_count) {
    let starRatingHtml = "";

    // 評価に応じた星マークを生成
    if (rating_ave >= 0 && rating_ave < 1) {
        starRatingHtml = `
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>`;
    } else if (rating_ave >= 1 && rating_ave < 2) {
        starRatingHtml = `
            <i style="color: #c4c403;" class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>`;
    } else if (rating_ave >= 2 && rating_ave < 3) {
        starRatingHtml = `
            <i style="color: #c4c403;" class="fas fa-star"></i>
            <i style="color: #c4c403;" class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>`;
    } else if (rating_ave >= 3 && rating_ave < 4) {
        starRatingHtml = `
            <i style="color: #c4c403;" class="fas fa-star"></i>
            <i style="color: #c4c403;" class="fas fa-star"></i>
            <i style="color: #c4c403;" class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>`;
    } else if (rating_ave >= 4 && rating_ave < 5) {
        starRatingHtml = `
            <i style="color: #c4c403;" class="fas fa-star"></i>
            <i style="color: #c4c403;" class="fas fa-star"></i>
            <i style="color: #c4c403;" class="fas fa-star"></i>
            <i style="color: #c4c403;" class="fas fa-star"></i>
            <i class="fas fa-star"></i>`;
    } else if (rating_ave === 5) {
        starRatingHtml = `
            <i style="color: #c4c403;" class="fas fa-star"></i>
            <i style="color: #c4c403;" class="fas fa-star"></i>
            <i style="color: #c4c403;" class="fas fa-star"></i>
            <i style="color: #c4c403;" class="fas fa-star"></i>
            <i style="color: #c4c403;" class="fas fa-star"></i>`;
    }

    // ドッグランカードのHTMLを生成
    return `
      <div class="store">
        <a href="${data.url}" class="store__link" target="_blank" rel="noopener noreferrer">
            <div class="store__pic">
                <img src="${host +
                    "/storage/image/shop/" + data.id + ".jpg"}" alt="">
            </div>
            <div class="store__content">
                <div class="store__name">${data.name}</div>
                <div class="store__hour">営業時間： ${data.time}</div>
                <div class="store__off">定休日： ${data.off}</div>
                <div class="store__address">住所：${data.address}</div>
                 <div class="store__price">料金：${data.price}</div>
                <div class="store__rating-count">口コミ件数 ： ${rating_count}件 </div>
            </div>
        </a>
        <div class="store__flex">
            <div class="store__btn-flex">
                <a class="store__phone" href="tel:${data.tel}">電話</a>
                <a class="store__review" href="${host + "/posts/" + data.id}">口コミ</a>
            </div>
            <div class="store__rating-star">${starRatingHtml}</div>
        </div>
      </div>
    `;
}

/**
 * 検索に使用するキーワードを取得する
 * @param {string} key - パラメータのキー
 * @returns {Array|false} キーワードの配列、キーワードがない場合はfalse
 */
function get_search_keywords(key) {
    // URLからパラメータ取得
    var params = [];
    var param = location.search.substring(1).split("&");

    for (var i = 0; i < param.length; i++) {
        params[i] = param[i].split("=");
    }
    
    // キーワードを配列形式で格納
    var keywords = [];
    var separator = / |　|\+/g; // スペース、全角スペース、+で区切り
    
    for (var i = 0; i < params.length; i++) {
        if (params[i][0] === key && params[i][1] !== undefined) {
            keywords = decodeURIComponent(params[i][1]).split(separator);
            break;
        }
    }
    
    // キーワードの値が空のものを除去
    keywords = keywords.filter(function(e) {
        return e !== "";
    });
    
    // キーワードがない場合はfalseを返す
    if (keywords.length <= 0) {
        return false;
    }
    
    // キーワードを小文字に変換（大文字小文字を区別しない検索のため）
    for (var i = 0; i < keywords.length; i++) {
        keywords[i] = keywords[i].toLowerCase();
    }

    return keywords;
}

/**
 * 記事内のキーワード検索
 * @param {Array} articleData - 検索する記事情報
 * @param {Array} keywords - 検索するキーワード
 * @param {Array} jsonKeys - 検索対象にする記事情報のキー
 * @returns {Array} 一致する記事のインデックス配列
 */
function keyword_search(articleData, keywords, jsonKeys) {
    var data = articleData;
    var h = [];
    
    // 検索対象の値を配列にまとめる
    for (var i = 0; i < data.length; i++) {
        var v = [];
        for (var j = 0; j < jsonKeys.length; j++) {
            var thisVal = data[i][jsonKeys[j]];
            // 値が配列の場合はその各値を取得
            if (Array.isArray(thisVal)) {
                for (var k = 0; k < thisVal.length; k++) {
                    v.push(thisVal[k].toLowerCase());
                }
            } else {
                v.push(thisVal.toLowerCase());
            }
        }
        h.push(v);
    }

    // 一致する配列のindexを取得
    var matchIndex = [];
    var matchCount;
    var thisArr;

    // 各記事のループ
    for (var i = 0; i < h.length; i++) {
        matchCount = 0;
        thisArr = h[i];
        // 検索キーワードでのループ
        for (var j = 0; j < keywords.length; j++) {
            // 記事の各項目でのループ
            for (var k = 0; k < thisArr.length; k++) {
                // 記事項目内に検索キーワードが含まれる場合
                if (thisArr[k].indexOf(keywords[j]) > -1) {
                    matchCount++;
                    break;
                }
            }
            // 検索キーワードが各項目に含まれなかった場合
            if (matchCount <= j) {
                break;
            }
            // 検索キーワードが全て記事に含まれていた場合
            if (matchCount >= keywords.length) {
                matchIndex.push(i);
            }
        }
    }
    return matchIndex;
}

/**
 * サービス条件に基づくフィルタリング
 * @param {Array} dataList - ドッグランデータ
 * @returns {Array} フィルタリングされたデータ
 */
function serviceLists(dataList) {
    let elements = [];
    let serviceList = [];
    let services = [];

    // URLパラメータからサービス条件を取得
    for (let i = 1; i <= 3; i++) {
        elements.push(params.get("services_" + i));
    }
    const filteredServices = elements.filter(v => v); // nullを削除

    // 各ドッグランのサービスと照合
    dataList.forEach(data => {
        services = [data.service_1, data.service_2, data.service_3];

        console.log(services);

        // 全ての指定サービスが含まれているかチェック
        if (filteredServices.every(service => services.includes(service))) {
            serviceList.push(data);
        }
    });

    return serviceList;
}

// ページ読み込み完了時にメイン処理を実行
initDogRun(); // 初期化処理を呼び出す
dogrun();
