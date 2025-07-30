let host = location.origin;
let html = ""; // HTMLの初期化
let count = 0; // countの初期化

const url_amazon = host + "/api/scraping/amazon";

// アマゾンアソシエイトの設定
const AMAZON_ASSOCIATE_TAG = window.AMAZON_ASSOCIATE_TAG; // 環境変数から取得、フォールバック用

// アマゾンアフィリエイトリンクを生成する関数
function createAmazonAffiliateLink(originalUrl) {
    try {
        const url = new URL(originalUrl);
        // 既存のパラメータを保持
        const params = new URLSearchParams(url.search);
        // アソシエイトタグを追加
        params.set('tag', AMAZON_ASSOCIATE_TAG);
        // 新しいURLを作成
        url.search = params.toString();
        return url.toString();
    } catch (error) {
        console.error("アフィリエイトリンクの生成に失敗しました:", error);
        return originalUrl; // エラーの場合は元のURLを返す
    }
}

async function fetchAmazon(url) {
    try {
        const response = await fetch(url); // fetch の結果を待つ
        return await response.json(); // JSON を返す
    } catch (e) {
        console.error("Error in fetchURLs:", e); // エラー処理
        return null; // エラーが発生した場合は null を返す
    }
}

async function Check(amazonData) {
    return new Promise(resolve => {
        const amazonDataList = amazonData.flatMap(item => item);
        resolve([amazonDataList]);
    });
}

async function dogFood() {
    // ローダーを表示
    const loader = document.getElementById("loader");
    if (loader) {
        loader.style.display = "block";
    }

    try {
        const amazonData = (await fetchAmazon(url_amazon)) || [];

        const [amazonDataList] = await Check(
            amazonData,
            []
        );

        if (amazonDataList.length === 0) {
            console.error("データが取得できませんでした。");
            return;
        }
        dataList(amazonDataList);
    } catch (error) {
        console.error("エラーが発生しました:", error);
    } finally {
        // ローダーを非表示
        if (loader) {
            loader.style.display = "none";
        }
    }
}

function dataList(amazonDataList) {
    const html_amazon = generateHTML(amazonDataList);

    displayResult_amazon(html_amazon);
}

function generateHTML(dataList) {
    let html = "";

    dataList.forEach(data => {
        html += createStoreHTML(data);
    });

    return [html];
}

function displayResult_amazon(html) {
    const element = document.getElementById("food__content_amazon");
    if (element) {
        element.insertAdjacentHTML("afterbegin", html);
    }
}

function createStoreHTML(data) {
    const price = data.price.replace(/￥/g, "");

    // アマゾンのURLの場合、アフィリエイトリンクを生成
    let affiliateUrl = data.url;
    if (data.url && data.url.includes('amazon.co.jp')) {
        affiliateUrl = createAmazonAffiliateLink(data.url);
    }

    return `
      <div class="food__store">
        <div class="food__store_count"># ${data.count}</div>
        <a href="${affiliateUrl}" class="food__store_link" target="_blank" rel="noopener noreferrer">
            <div class="food__store_pic">
                <img src="${data.img}" alt="">
            </div>
            <div class="food__store_content">
                <div class="food__store_title">${data.title}</div>
                 <div class="food__store_price">料金：${price} 円</div>
            </div>
        </a>
      </div>
    `;
}

dogFood();
