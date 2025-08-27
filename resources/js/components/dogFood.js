let host = location.origin;
let html = ''; // HTMLの初期化
let count = 0; // countの初期化

const url_amazon = host + '/api/scraping/amazon';

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
    console.error('アフィリエイトリンクの生成に失敗しました:', error);
    return originalUrl; // エラーの場合は元のURLを返す
  }
}

async function fetchAmazon(url) {
  try {
    const response = await fetch(url);
    
    if (!response.ok) {
      throw new Error(`HTTP error! status: ${response.status}`);
    }
    
    const data = await response.json();
    
    // 新しいAPIレスポンス形式に対応
    if (data.success && data.data) {
      return data.data;
    } else {
      console.error('APIエラー:', data.message || 'データが取得できませんでした');
      return [];
    }
    
  } catch (e) {
    console.error('Error in fetchAmazon:', e);
    return [];
  }
}

async function Check(amazonData) {
  return new Promise((resolve) => {
    if (!Array.isArray(amazonData)) {
      resolve([]);
      return;
    }
    
    const amazonDataList = amazonData.flatMap((item) => item);
    resolve([amazonDataList]);
  });
}

async function dogFood() {
  // ローダーを表示
  const loader = document.getElementById('loader');
  if (loader) {
    loader.style.display = 'block';
  }

  try {
    const amazonData = await fetchAmazon(url_amazon);

    if (!amazonData || amazonData.length === 0) {
      console.error('データが取得できませんでした。');
      showErrorMessage('データの取得に失敗しました。しばらく時間をおいて再度お試しください。');
      return;
    }

    const [amazonDataList] = await Check(amazonData, []);

    if (amazonDataList.length === 0) {
      console.error('データが取得できませんでした。');
      showErrorMessage('データの処理に失敗しました。');
      return;
    }
    
    dataList(amazonDataList);
  } catch (error) {
    console.error('エラーが発生しました:', error);
    showErrorMessage('予期しないエラーが発生しました。');
  } finally {
    // ローダーを非表示
    if (loader) {
      loader.style.display = 'none';
    }
  }
}

function dataList(amazonDataList) {
  const html_amazon = generateHTML(amazonDataList);

  displayResult_amazon(html_amazon);
}

function generateHTML(dataList) {
  let html = '';

  // 最大12個まで表示
  const displayCount = Math.min(dataList.length, 12);
  for (let i = 0; i < displayCount; i++) {
    const data = dataList[i];
    html += createStoreHTML(data);
  }

  return [html];
}

function displayResult_amazon(html) {
  const element = document.getElementById('food__content_amazon');
  if (element) {
    element.insertAdjacentHTML('afterbegin', html);
  }
}

function createStoreHTML(data) {
  const price = data.price.replace(/￥/g, '');

  // アマゾンのURLの場合、アフィリエイトリンクを生成
  let affiliateUrl = data.url;
  if (data.url && data.url.includes('amazon.co.jp')) {
    affiliateUrl = createAmazonAffiliateLink(data.url);
  }

  return `
      <div class="food__store">
        <div class="food__store_wrap">
            <div class="food__store_count"><span>${data.count}位</span></div>
        </div>
        <a href="${affiliateUrl}" class="food__store_link" target="_blank" rel="noopener noreferrer">
            <div class="food__store_pic">
                <img src="${data.img}" alt="">
            </div>
            <div class="food__store_content">
                <div class="food__store_title">${data.title}</div>
                <div class="food__store_price"><span>${price}</span> 円</div>
            </div>
        </a>
      </div>
    `;
}

function showErrorMessage(message) {
  const element = document.getElementById('food__content_amazon');
  if (element) {
    element.innerHTML = `
      <div class="error-message" style="text-align: center; padding: 20px; color: #666;">
        <p>${message}</p>
        <button onclick="location.reload()" style="margin-top: 10px; padding: 8px 16px; background: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer;">
          再読み込み
        </button>
      </div>
    `;
  }
}

dogFood();

// passiveイベントリスナーの警告を解決
document.addEventListener('touchstart', function() {}, { passive: true });
document.addEventListener('touchmove', function() {}, { passive: true });
document.addEventListener('wheel', function() {}, { passive: true });
