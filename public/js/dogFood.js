let host = location.origin;
let html = ""; // HTMLの初期化
let count = 0; // countの初期化

const url_amazon = host + "/api/scraping/amazon";
const url_yahoo = host + "/api/scraping/yahoo";

async function fetchAmazon(url) {
    try {
        const response = await fetch(url); // fetch の結果を待つ
        return await response.json(); // JSON を返す
    } catch (e) {
        console.error("Error in fetchURLs:", e); // エラー処理
        return null; // エラーが発生した場合は null を返す
    }
}

async function fetchYahoo(url) {
    try {
        const response = await fetch(url); // fetch の結果を待つ
        return await response.json(); // JSON を返す
    } catch (e) {
        console.error("Error in fetchURLs:", e); // エラー処理
        return null; // エラーが発生した場合は null を返す
    }
}

async function Check(amazonData, yahooData) {
    return new Promise(resolve => {
        const amazonDataList = amazonData.flatMap(item => item);
        const yahooDataList = yahooData.flatMap(item => item);
        resolve([amazonDataList, yahooDataList]);
    });
}

async function dogFood() {
    // ローダーを表示
    const loader = document.getElementById("loader");
    loader.style.display = "block";

    try {
        const amazonData = (await fetchAmazon(url_amazon)) || [];
        const yahooData = (await fetchYahoo(url_yahoo)) || [];

        const [amazonDataList, yahooDataList] = await Check(
            amazonData,
            yahooData
        );

        if (amazonDataList.length === 0 && yahooDataList.length === 0) {
            console.error("データが取得できませんでした。");
            return;
        }

        dataList(amazonDataList, yahooDataList);
    } catch (error) {
        console.error("エラーが発生しました:", error);
    } finally {
        // ローダーを非表示
        loader.style.display = "none";
    }
}

function dataList(amazonDataList, yahooDataList) {
    const html_amazon = generateHTML(amazonDataList);
    const html_yahoo = generateHTML(yahooDataList);

    displayResult_amazon(html_amazon);
    displayResult_yahoo(html_yahoo);
}

function generateHTML(dataList) {
    let html = "";

    dataList.forEach(data => {
        html += createStoreHTML(data);
    });

    return [html];
}

function displayResult_amazon(html) {
    document
        .getElementById("result__content_amazon")
        .insertAdjacentHTML("afterbegin", html);
}

function displayResult_yahoo(html) {
    document
        .getElementById("result__content_yahoo")
        .insertAdjacentHTML("afterbegin", html);
}

function createStoreHTML(data) {
    const price = data.price.replace(/￥/g, "");

    return `
      <div class="store">
        <div class="store__count"># ${data.count}</div>
        <a href="${data.url}" class="store__link" target="_blank" rel="noopener noreferrer">
            <div class="store__pic">
                <img src="${data.img}" alt="">
            </div>
            <div class="store__content">
                <div class="store__title">${data.title}</div>
                 <div class="store__price">料金：${price} 円</div>
            </div>
        </a>
      </div>
    `;
}

dogFood();
