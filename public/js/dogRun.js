let params = new URLSearchParams(document.location.search);
let places = location.pathname
    .replace(/\/+$/, "")
    .split("/")
    .pop();
let host = location.origin;
let html = ""; // HTMLの初期化
let count = 0; // countの初期化

const urls = [
    host + "/api/place/yamaguchi",
    host + "/api/place/hagi",
    host + "/api/place/syuunan",
    host + "/api/place/shimonoseki",
    host + "/api/place/houhu",
    host + "/api/place/ubeonoda",
    host + "/api/place/iwakunihikari"
];
const ratingurl = host + "/api/place/rating";

const regions = [
    "yamaguchi",
    "shimonoseki",
    "houhu",
    "hagi",
    "syuunan",
    "ubeonoda",
    "iwakunihikari"
];

async function fetchURLs(urls) {
    try {
        // fetch で各URLの結果を取得して result 配列に格納
        const results = await Promise.all(
            urls.map(url =>
                fetch(url)
                    .then(response => response.json()) // JSONデータを返す
                    .catch(e => {
                        console.error(`Error fetching ${url}:`, e); // エラー処理
                        return null; // エラーが発生した場合は null を返す
                    })
            )
        );

        // エラーチェックを含む、null以外の結果のみを使用
        return results.filter(result => result !== null);
    } catch (error) {
        console.error("Error in fetchURLs:", error);
    }
}

async function fetchRatings(ratingurl) {
    try {
        const response = await fetch(ratingurl); // fetch の結果を待つ
        return await response.json(); // JSON を返す
    } catch (e) {
        console.error("Error in fetchURLs:", e); // エラー処理
        return null; // エラーが発生した場合は null を返す
    }
}

// geolocation_check 関数
async function geolocationCheck(result, ratings) {
    return new Promise((resolve, reject) => {
        const dataList = result.flatMap(item => item);
        const ratingList = ratings.flatMap(item => item);
        if (!navigator.geolocation) {
            // Geolocation がサポートされていない場合
            reject(["Geolocation is not supported by this browser.", dataList]);
        } else {
            navigator.geolocation.getCurrentPosition(
                position => {
                    resolve([position, dataList, ratingList]);
                },
                error => {
                    reject([error, dataList, ratingList]);
                },
                {
                    enableHighAccuracy: true, //位置情報の精度を高く
                    timeout: 10000, //10秒でタイムアウト
                    maximumAge: 600000 //10分間有効
                }
            );
        }
    });
}

async function dogrun() {
    const results = await fetchURLs(urls);
    const ratings = await fetchRatings(ratingurl);

    if (results.length > 0) {
        try {
            const [position, dataList, ratingList] = await geolocationCheck(
                results,
                ratings
            );
            CurrentPosition(position, dataList, ratingList);
        } catch ([error, dataList, ratingList]) {
            notCurrentPosition(error, dataList, ratingList);
        }
    }
}

function CurrentPosition(position, dataList, ratingList) {
    const coords = position.coords;

    // 距離の計算
    dataList.forEach(data => {
        data.distance =
            getDistance(
                data.lat,
                data.lng,
                coords.latitude,
                coords.longitude,
                0
            ) / 1000;
    });

    dataList.sort((a, b) => a.distance - b.distance);

    // const regions = ["yamaguchi", "hiroshima", "okayama", "shimane", "tottori"];

    if (places === "position") {
        // 現在地から近い2つを表示
        const limitedData = dataList.slice(0, 2);
        const html_count = generateHTML(limitedData, true, ratingList);
        html = html_count[0];
        count = `${html_count[1]}件`;
    } else if (regions.includes(places)) {
        // 地域ごとの表示
        const filteredData = dataList.filter(data => data.tag === places);
        const html_count = generateHTML(filteredData, true, ratingList);
        html = html_count[0];
        count = `${html_count[1]}件`;
    } else if (params.get("keyword")) {
        // キーワード検索
        const s = get_search_keywords("keyword");
        const jsonKeys = ["name", "address"];
        const index = keyword_search(dataList, s, jsonKeys);
        if (index.length > 0) {
            const searchResults = index.map(i => dataList[i]);
            const html_count = generateHTML(searchResults, true, ratingList);
            html = html_count[0];
            count = `${html_count[1]}件`;
        } else {
            displayNoResults();
        }
    } else if (
        params.get("services_1") ||
        params.get("services_2") ||
        params.get("services_3")
    ) {
        // サービス条件に基づくフィルタリング
        const serviceFilteredData = serviceLists(dataList);
        const html_count = generateHTML(serviceFilteredData, false, ratingList);
        html = html_count[0];
        count = `${html_count[1]}件`;
    } else {
        const html_count = generateHTML(dataList, false, ratingList);
        html = html_count[0];
        count = `${html_count[1]}件`;
    }

    displayResults(html, count);
}

function notCurrentPosition(error, dataList, ratingList) {
    if (places === "position") {
        alert(
            "お使いの端末の位置情報サービスが無効になっているか、エラーが発生しました"
        );
        console.error(error);
        count = "0件";
        html = "";
    } else if (regions.includes(places)) {
        // フラット化したデータを使用してフィルタリング
        const filteredData = dataList.filter(data => data.tag === places);

        const html_count = generateHTML(filteredData, false, ratingList);
        html = html_count[0];
        count = `${html_count[1]}件`;
    } else if (params.get("keyword")) {
        const s = get_search_keywords("keyword");
        const jsonKeys = ["name", "address"];
        const index = keyword_search(dataList, s, jsonKeys);
        if (index.length > 0) {
            const searchResults = index.map(i => dataList[i]);
            const html_count = generateHTML(searchResults, false, ratingList);
            html = html_count[0];
            count = `${html_count[1]}件`;
        } else {
            displayNoResults();
        }
    } else if (
        params.get("services_1") ||
        params.get("services_2") ||
        params.get("services_3")
    ) {
        // サービス条件に基づくフィルタリング
        const serviceFilteredData = serviceLists(dataList);

        const html_count = generateHTML(serviceFilteredData, false, ratingList);
        html = html_count[0];
        count = `${html_count[1]}件`;
    } else {
        const html_count = generateHTML(dataList, false, ratingList);
        html = html_count[0];
        count = `${html_count[1]}件`;
    }

    displayResults(html, count);
}

function generateHTML(dataList, showDistance, ratingList) {
    let html = "";
    let rating_count = rating_sum = rating_ave = 0;

    dataList.forEach(data => {
        for (let i = 0; i < ratingList.length; i++) {

            if (data["id"] == ratingList[i]["place"]) {
                rating_sum += ratingList[i]["rating"];
                rating_count++;
            }
        }
        rating_ave = rating_sum / rating_count;

        if (isNaN(rating_ave)) {
            rating_ave = 0;
        }

        html += createStoreHTML(data, showDistance, rating_ave, rating_count);
        rating_count = rating_sum = rating_ave = 0;
    });

    return [html, dataList.length];
}

function displayResults(html, count) {
    document
        .getElementById("js-result-count")
        .insertAdjacentHTML("afterbegin", count);
    document
        .getElementById("result__content")
        .insertAdjacentHTML("afterbegin", html);
}

function displayNoResults() {
    alert("キーワードに一致する記事がありませんでした。");
    const noResultHTML = `
      <span>ご指定の検索条件に合う店舗が見つかりませんでした。</span>
      <span>大変お手数ですが、条件を変えて再度検索してください。</span>
    `;
    document
        .getElementById("resultNoStore")
        .insertAdjacentHTML("afterbegin", noResultHTML);
    count = "0件";
    html = "";
}

function createStoreHTML(data, showDistance, rating_ave, rating_count) {
    let starRatingHtml = "";

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

    return `
      <div class="store">
        <a href="${data.url}" class="store__link">
            <div class="store__pic">
                <img src="${host +
                    "/storage/image/shop/" +
                    data.id +
                    ".jpg"}" alt="">
            </div>
            <div class="store__content">
                <div class="store__name">${data.name}</div>
                ${
                    showDistance && data.distance
                        ? `<div class="store__distance">現在地距離： ${data.distance.toFixed(
                              2
                          )}km</div>`
                        : ""
                }
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
                <a class="store__review" href="${host + "/user/posts/" + data.id}">口コミ</a>
            </div>
            <div class="store__rating-star">${starRatingHtml}</div>
        </div>
      </div>
    `;
}

/**
 * 検索に使用するキーワードを取得する
 * キーワードがない場合はfalseを返す
 * @param {string} key (required) パラメータのkey
 */

var paramKey = "keyword"; // 検索キーワードとして取得するパラメータのキー
var jsonKeys = ["name", "address"]; // 検索対象にするjson内のキー
var s = get_search_keywords(get_search_keywords);

function get_search_keywords(key) {
    // URLからパラメータ取得
    var params = [];
    var param = location.search.substring(1).split("&");

    for (var i = 0; i < param.length; i++) {
        params[i] = param[i].split("=");
    }
    // キーワードを配列形式で格納
    var keywords = [];
    var separator = / |　|\+/g;
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
    // キーワードを小文字に変換
    for (var i = 0; i < keywords.length; i++) {
        keywords[i] = keywords[i].toLowerCase();
    }

    return keywords;
}

/**
 * 記事内のキーワード検索
 * @param {object} articleData (required) 検索する記事情報
 * @param {array}  keywords    (required) 検索するキーワード
 * @param {array}  jsonKeys    (required) 検索対象にする記事情報のキー
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
 * 2点間の緯度経度から距離を取得
 * 測地線航海算法を使用して距離を算出する。
 * @see http://hamasyou.com/blog/2010/09/07/post-2/
 * @param float 緯度1
 * @param float 経度2
 * @param float 緯度2
 * @param float 経度2
 * @param 小数点以下の桁数(べき乗で算出精度を指定)
 */
function getDistance(lat1, lng1, lat2, lng2, precision) {
    var distance = 0;
    if (Math.abs(lat1 - lat2) < 0.00001 && Math.abs(lng1 - lng2) < 0.00001) {
        distance = 0;
    } else {
        lat1 = (lat1 * Math.PI) / 180;
        lng1 = (lng1 * Math.PI) / 180;
        lat2 = (lat2 * Math.PI) / 180;
        lng2 = (lng2 * Math.PI) / 180;

        var A = 6378140;
        var B = 6356755;
        var F = (A - B) / A;

        var P1 = Math.atan((B / A) * Math.tan(lat1));
        var P2 = Math.atan((B / A) * Math.tan(lat2));

        var X = Math.acos(
            Math.sin(P1) * Math.sin(P2) +
                Math.cos(P1) * Math.cos(P2) * Math.cos(lng1 - lng2)
        );
        var L =
            (F / 8) *
            (((Math.sin(X) - X) * Math.pow(Math.sin(P1) + Math.sin(P2), 2)) /
                Math.pow(Math.cos(X / 2), 2) -
                ((Math.sin(X) - X) * Math.pow(Math.sin(P1) - Math.sin(P2), 2)) /
                    Math.pow(Math.sin(X), 2));

        distance = A * (X + L);
        var decimal_no = Math.pow(10, precision);
        distance = Math.round((decimal_no * distance) / 1) / decimal_no;
    }
    return distance;
}

function serviceLists(dataList) {
    let elements = [];
    let serviceList = [];
    let services = [];

    for (let i = 1; i <= 3; i++) {
        elements.push(params.get("services_" + i));
    }
    const filteredServices = elements.filter(v => v); // nullを削除

    dataList.forEach(data => {
        services = [data.service_1, data.service_2, data.service_3];

        console.log(services);

        if (filteredServices.every(service => services.includes(service))) {
            serviceList.push(data);
        }
    });

    return serviceList;
}

dogrun();
