/**
 * Google Maps APIを使用した山口県地図システム
 *
 * このファイルは以下の主要機能を提供します：
 * 1. レスポンシブ対応の地図表示（SP/デスクトップで異なる設定）
 * 2. 主要都市のマーカー表示
 * 3. ドッグランのカスタムマーカー表示
 * 4. 情報ウィンドウでの詳細表示
 * 5. 地図の操作制限（デスクトップ時）
 */

// Google Maps APIを使用した山口県地図
class GoogleMapsMap {
  constructor() {
    this.host = location.origin;
    // 全ドッグランデータを1つのAPIエンドポイントで取得
    this.urls = [this.host + '/api/place/all'];
    this.map = null; // Google Mapsのインスタンス
    this.markers = []; // カスタムマーカーの配列
    this.infoWindow = null; // 情報ウィンドウのインスタンス
    this.init();
  }

  /**
   * 初期化処理
   */
  init() {
    // Google Maps APIが完全に読み込まれているかチェック
    if (
      typeof google === 'undefined' ||
      typeof google.maps === 'undefined' ||
      typeof google.maps.MapTypeId === 'undefined' ||
      typeof google.maps.Map === 'undefined'
    ) {
      console.error(
        'Google Maps API が完全に読み込まれていません。少し待ってから再試行します。'
      );
      // 少し待ってから再試行
      setTimeout(() => this.init(), 200);
      return;
    }

    this.createMap();

    // 地図の作成が成功した場合のみデータを読み込む
    if (this.map) {
      this.loadMapData();
    }
  }

  /**
   * 地図の作成と初期設定
   */
  createMap() {
    // 地図要素の存在チェック
    const mapElement = document.getElementById('google-map');

    if (!mapElement) {
      console.error('地図要素 #google-map が見つかりません');
      return;
    }

    // 画面サイズに応じて地図の中心座標とズームレベルを調整
    const isMobile = window.innerWidth <= 768;
    let yamaguchiCenter, zoomLevel;

    if (isMobile) {
      // SP時：山口県全体が見えるように調整
      yamaguchiCenter = { lat: 34.2, lng: 131.4 };
      zoomLevel = 8; // より広い範囲を表示
    } else {
      // デスクトップ時：従来の設定
      yamaguchiCenter = { lat: 34.1858, lng: 131.6 };
      zoomLevel = 9;
    }

    try {
      // 地図の作成（レスポンシブ対応）
      this.map = new google.maps.Map(mapElement, {
        center: yamaguchiCenter,
        zoom: zoomLevel,
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        styles: this.getMapStyles(),
        mapTypeControl: false, // 地図タイプコントロールを非表示
        streetViewControl: false, // ストリートビューコントロールを非表示
        fullscreenControl: false, // フルスクリーンコントロールを非表示
        zoomControl: false, // ズームコントロールを非表示
        scaleControl: false, // スケールコントロールを非表示
        rotateControl: false, // 回転コントロールを非表示
        clickableIcons: true, // マーカーのクリックを有効化
        draggable: isMobile, // SP時のみ地図のドラッグを有効化
        scrollwheel: false, // スクロールホイールでのズームを無効化
        keyboardShortcuts: false, // キーボードショートカットを無効化
      });

      // 地図の操作を制限するイベントリスナー（レスポンシブ対応）
      if (!isMobile) {
        // デスクトップ時のみ操作を制限
        this.map.addListener('dragstart', (e) => {
          e.stop();
        });

        this.map.addListener('zoom_changed', () => {
          this.map.setZoom(9);
        });

        this.map.addListener('center_changed', () => {
          this.map.setCenter(yamaguchiCenter);
        });
      } else {
        // SP時は適切な範囲内での操作を許可
        this.map.addListener('zoom_changed', () => {
          const currentZoom = this.map.getZoom();
          if (currentZoom < 7 || currentZoom > 10) {
            // 適切な範囲外のズームは制限
            const restrictedZoom = currentZoom < 7 ? 7 : 10;
            this.map.setZoom(restrictedZoom);
          }
        });
      }

      // 主要都市のマーカーを追加
      this.addCityMarkers();

      // 情報ウィンドウの作成
      this.infoWindow = new google.maps.InfoWindow({
        maxWidth: 300,
        pixelOffset: new google.maps.Size(0, -10),
        disableAutoPan: true, // 自動パンを無効化（地図の中心を動かさない）
        shouldFocus: false,
        closeBoxURL: '', // 閉じるボタンを非表示
        enableCloseButton: false, // 閉じるボタンを無効化
        zIndex: 10001, // カスタムマーカー（10000）より高い値で上に表示
      });
    } catch (error) {
      console.error('地図の作成に失敗しました:', error);
      // エラーが発生した場合は少し待ってから再試行
      setTimeout(() => this.createMap(), 200);
    }
  }

  /**
   * 地図のスタイル設定（カスタマイズされた見た目）
   * @returns {Array} スタイル設定の配列
   */
  getMapStyles() {
    return [
      // 地図の全体的なスタイル
      {
        featureType: 'all',
        elementType: 'geometry',
        stylers: [{ saturation: -20 }, { lightness: 10 }],
      },
      // 水域のスタイル（海や川を青く見やすく）
      {
        featureType: 'water',
        elementType: 'geometry',
        stylers: [{ color: '#a8d8ff' }, { lightness: 20 }],
      },
      // 陸地のスタイル（緑色で見やすく）
      {
        featureType: 'landscape',
        elementType: 'geometry',
        stylers: [{ color: '#f0f8e8' }, { lightness: 15 }],
      },
      // 道路のスタイル（白く見やすく）
      {
        featureType: 'road',
        elementType: 'geometry',
        stylers: [{ color: '#ffffff' }, { lightness: 100 }],
      },
      // 道路のラベル（見やすい色に）
      {
        featureType: 'road',
        elementType: 'labels.text.fill',
        stylers: [{ color: '#7c7c7c' }],
      },
      // 建物のスタイル（緑色で見やすく）
      {
        featureType: 'poi',
        elementType: 'geometry',
        stylers: [{ color: '#e8f4d8' }, { lightness: 20 }],
      },
      // POIラベルを非表示（地図をすっきりさせる）
      {
        featureType: 'poi',
        elementType: 'labels',
        stylers: [{ visibility: 'off' }],
      },
      // 交通機関のラベルを非表示
      {
        featureType: 'transit',
        elementType: 'labels',
        stylers: [{ visibility: 'off' }],
      },
      // 鉄道・新幹線の線路を非表示
      {
        featureType: 'transit.line',
        elementType: 'geometry',
        stylers: [{ visibility: 'off' }],
      },
      // 鉄道・新幹線の駅を非表示
      {
        featureType: 'transit.station',
        elementType: 'geometry',
        stylers: [{ visibility: 'off' }],
      },
      // 鉄道・新幹線の線路のラベルを非表示
      {
        featureType: 'transit.line',
        elementType: 'labels',
        stylers: [{ visibility: 'off' }],
      },
      // 鉄道・新幹線の駅のラベルを非表示
      {
        featureType: 'transit.station',
        elementType: 'labels',
        stylers: [{ visibility: 'off' }],
      },
      // 鉄道・新幹線の線路のストロークを非表示
      {
        featureType: 'transit.line',
        elementType: 'geometry.stroke',
        stylers: [{ visibility: 'off' }],
      },
      // 鉄道・新幹線の駅のストロークを非表示
      {
        featureType: 'transit.station',
        elementType: 'geometry.stroke',
        stylers: [{ visibility: 'off' }],
      },
      // 鉄道・新幹線の線路の色を消す
      {
        featureType: 'transit.line',
        elementType: 'geometry.fill',
        stylers: [{ visibility: 'off' }],
      },
      // 鉄道・新幹線の駅の色を消す
      {
        featureType: 'transit.station',
        elementType: 'geometry.fill',
        stylers: [{ visibility: 'off' }],
      },
      // 鉄道・新幹線の線路のアイコンを非表示
      {
        featureType: 'transit.line',
        elementType: 'labels.icon',
        stylers: [{ visibility: 'off' }],
      },
      // 鉄道・新幹線の駅のアイコンを非表示
      {
        featureType: 'transit.station',
        elementType: 'labels.icon',
        stylers: [{ visibility: 'off' }],
      },
      // 鉄道・新幹線の線路のテキストを非表示
      {
        featureType: 'transit.line',
        elementType: 'labels.text',
        stylers: [{ visibility: 'off' }],
      },
      // 鉄道・新幹線の駅のテキストを非表示
      {
        featureType: 'transit.station',
        elementType: 'labels.text',
        stylers: [{ visibility: 'off' }],
      },
      // 行政境界のスタイル（県境などを表示）
      {
        featureType: 'administrative',
        elementType: 'geometry.stroke',
        stylers: [{ color: '#c9c9c9' }, { weight: 1 }],
      },
      // 行政境界のラベル
      {
        featureType: 'administrative.locality',
        elementType: 'labels.text.fill',
        stylers: [{ color: '#4a4a4a' }],
      },
      // デフォルトのタイトルを非表示
      {
        featureType: 'poi',
        elementType: 'labels.text',
        stylers: [{ visibility: 'off' }],
      },
      // 地名ラベルを非表示
      {
        featureType: 'administrative.locality',
        elementType: 'labels.text',
        stylers: [{ visibility: 'off' }],
      },
      // 行政区域のラベルを非表示
      {
        featureType: 'administrative.administrative',
        elementType: 'labels.text',
        stylers: [{ visibility: 'off' }],
      },
    ];
  }

  /**
   * 主要都市のマーカーを地図に追加
   */
  addCityMarkers() {
    if (!this.map) {
      console.error('地図が初期化されていません');
      return;
    }

    // 主要都市の座標と情報
    const cities = [
      { name: '山口市', lat: 34.1858, lng: 131.4704, type: 'capital' },
      { name: '防府市', lat: 34.0561, lng: 131.5683, type: 'major' },
      { name: '周南市', lat: 34.0556, lng: 131.8028, type: 'major' },
      { name: '岩国市', lat: 34.1667, lng: 132.2167, type: 'major' },
      { name: '下関市', lat: 33.95, lng: 130.95, type: 'major' },
      { name: '萩市', lat: 34.4083, lng: 131.4, type: 'major' },
      { name: '宇部市', lat: 33.95, lng: 131.25, type: 'major' },
      { name: '小野田市', lat: 34.0, lng: 131.1833, type: 'minor' },
      { name: '光市', lat: 34.0167, lng: 131.9833, type: 'minor' },
    ];

    cities.forEach((city) => {
      // 非推奨警告を抑制するため、console.warnを一時的に無効化
      const originalWarn = console.warn;
      console.warn = () => {};
      try {
        const marker = new google.maps.Marker({
          position: { lat: city.lat, lng: city.lng },
          map: this.map,
          title: city.name,
          zIndex: 999, // 都市マーカーのz-index
          clickable: true, // クリック可能を明示的に設定
          draggable: false, // ドラッグは無効
          icon: this.getCityMarkerIcon(city.type),
          label: {
            text: city.name,
            className: 'city-label',
          },
        });
      } finally {
        // console.warnを元に戻す
        console.warn = originalWarn;
      }
    });
  }

  /**
   * 都市の種類に応じたマーカーアイコンを取得
   * @param {string} type - 都市の種類（capital: 県庁所在地, major: 主要都市, minor: その他）
   * @returns {Object} マーカーアイコンの設定
   */
  getCityMarkerIcon(type) {
    if (type === 'capital') {
      // 県庁所在地（山口市）- 赤色で目立つ
      return {
        path: google.maps.SymbolPath.CIRCLE,
        scale: 10,
        fillColor: '#FF6B6B',
        fillOpacity: 0.9,
        strokeColor: '#FFFFFF',
        strokeWeight: 3,
      };
    } else if (type === 'major') {
      // 主要都市 - 青色で目立つ
      return {
        path: google.maps.SymbolPath.CIRCLE,
        scale: 8,
        fillColor: '#4ECDC4',
        fillOpacity: 0.9,
        strokeColor: '#FFFFFF',
        strokeWeight: 2,
      };
    } else {
      // その他の都市 - 緑色で控えめ
      return {
        path: google.maps.SymbolPath.CIRCLE,
        scale: 6,
        fillColor: '#45B7D1',
        fillOpacity: 0.8,
        strokeColor: '#FFFFFF',
        strokeWeight: 2,
      };
    }
  }

  /**
   * 地図データの読み込みとマーカーの作成
   */
  async loadMapData() {
    try {
      // ドッグランデータを取得
      const results = await this.fetchURLs(this.urls);

      if (results.length > 0) {
        // 全ドッグランデータを1つのAPIエンドポイントで取得
        const dataList = results[0];
        this.createDogrunMarkers(dataList);
      }
    } catch (error) {
      console.error('Error loading map data:', error);
    }
  }

  /**
   * 指定されたURLからデータを取得する
   * @param {string[]} urls - 取得するURLの配列
   * @returns {Promise<Array>} 取得したデータの配列
   */
  async fetchURLs(urls) {
    try {
      // allエンドポイントから全データを取得
      const response = await fetch(urls[0]);
      if (!response.ok) {
        throw new Error(`HTTP error! status: ${response.status}`);
      }
      const data = await response.json();
      return [data]; // 配列形式を維持して既存の処理との互換性を保つ
    } catch (error) {
      console.error('Error in fetchURLs:', error);
      return [];
    }
  }

  /**
   * ドッグランデータを地図に表示する
   * @param {Array} results - ドッグランデータ
   */
  createDogrunMarkers(results) {
    if (!this.map) {
      console.error('地図が初期化されていません');
      return;
    }

    // 各ドッグランにマーカーを作成
    results.forEach((dogrun, index) => {
      if (dogrun.lat && dogrun.lng) {
        console.log(`ドッグラン ${index + 1}:`, {
          name: dogrun.name,
          lat: dogrun.lat,
          lng: dogrun.lng,
          address: dogrun.address,
        });
        this.createDogrunMarker(dogrun, index);
      } else {
        console.log(`座標なし: ${dogrun.name}`, {
          lat: dogrun.lat,
          lng: dogrun.lng,
        });
      }
    });

    // マーカーの作成完了を確認
    if (this.markers[0]) {
      console.log('最初のマーカーのイベント:', this.markers[0].gm_bindings_);
    }
  }

  /**
   * 個別のドッグランマーカーを作成
   * @param {Object} dogrun - ドッグランデータ
   * @param {number} index - インデックス
   */
  createDogrunMarker(dogrun, index) {
    const position = {
      lat: parseFloat(dogrun.lat),
      lng: parseFloat(dogrun.lng),
    };

    // 非推奨警告を抑制するため、console.warnを一時的に無効化
    const originalWarn = console.warn;
    console.warn = () => {};

    try {
      // カスタムマーカー要素を作成（Google Mapsの上に配置）
      const customMarker = document.createElement('div');
      customMarker.className = 'custom-dogrun-marker';

      // マーカーのツールチップ
      customMarker.title = dogrun.name;

      // カスタムマーカーを地図に追加
      const mapDiv = this.map.getDiv();
      mapDiv.appendChild(customMarker);

      // マーカーの位置を計算して配置
      const updateMarkerPosition = () => {
        const projection = this.map.getProjection();
        if (projection) {
          const point = projection.fromLatLngToPoint(position);
          const scale = Math.pow(2, this.map.getZoom());
          const center = this.map.getCenter();
          const centerPoint = projection.fromLatLngToPoint(center);
          const mapSize = this.map.getDiv().getBoundingClientRect();

          const x = (point.x - centerPoint.x) * scale + mapSize.width / 2;
          const y = (point.y - centerPoint.y) * scale + mapSize.height / 2;

          customMarker.style.left = x + 'px';
          customMarker.style.top = y + 'px';
        }
      };

      // 初期位置を設定
      updateMarkerPosition();

      // 地図の移動・ズーム時にマーカー位置を更新
      this.map.addListener('bounds_changed', () => {
        updateMarkerPosition();
      });

      // ズーム変更時にもマーカー位置を更新
      this.map.addListener('zoom_changed', () => {
        updateMarkerPosition();
      });

      // マーカーのホバーイベント
      customMarker.addEventListener('mouseenter', () => {
        customMarker.style.transform = 'translate(-50%, -50%) scale(1.2)';
        customMarker.style.boxShadow = '0 4px 12px rgba(0,0,0,0.4)';

        // 既存の情報ウィンドウを閉じる
        this.infoWindow.close();

        // カスタム情報ウィンドウを作成（Google MapsのInfoWindowの代わり）
        const customInfoWindow = document.createElement('div');
        customInfoWindow.className = 'custom-info-window';
        customInfoWindow.textContent = dogrun.name;

        // カスタム情報ウィンドウを地図に追加
        const mapDiv = this.map.getDiv();
        mapDiv.appendChild(customInfoWindow);

        // カスタム情報ウィンドウの位置を計算して配置
        const updateInfoWindowPosition = () => {
          const projection = this.map.getProjection();
          if (projection) {
            const point = projection.fromLatLngToPoint({
              lat: position.lat + 0.03,
              lng: position.lng,
            });
            const scale = Math.pow(2, this.map.getZoom());
            const center = this.map.getCenter();
            const centerPoint = projection.fromLatLngToPoint(center);
            const mapSize = this.map.getDiv().getBoundingClientRect();

            const x = (point.x - centerPoint.x) * scale + mapSize.width / 2;
            const y = (point.y - centerPoint.y) * scale + mapSize.height / 2;

            customInfoWindow.style.left = x + 'px';
            customInfoWindow.style.top = y - 25 + 'px'; // マーカーの上25pxに表示
          }
        };

        // 初期位置を設定
        updateInfoWindowPosition();

        // 地図の移動・ズーム時に情報ウィンドウ位置を更新
        const boundsListener = this.map.addListener(
          'bounds_changed',
          updateInfoWindowPosition
        );
        const zoomListener = this.map.addListener(
          'zoom_changed',
          updateInfoWindowPosition
        );

        // カスタム情報ウィンドウをマーカーオブジェクトに保存
        customMarker.customInfoWindow = customInfoWindow;
        customMarker.boundsListener = boundsListener;
        customMarker.zoomListener = zoomListener;
      });

      // マーカーのクリックイベント
      customMarker.addEventListener('click', () => {
        console.log(`カスタムマーカークリック: ${dogrun.name}`);
        if (dogrun.url) {
          window.open(dogrun.url, '_blank');
        } else {
          console.log('ドッグランにURLが設定されていません:', dogrun.name);
        }
      });

      // マーカーのマウスアウトイベント
      customMarker.addEventListener('mouseleave', () => {
        customMarker.style.transform = 'translate(-50%, -50%) scale(1)';
        customMarker.style.boxShadow = '0 2px 8px rgba(0,0,0,0.3)';

        // カスタム情報ウィンドウを削除
        if (customMarker.customInfoWindow) {
          // イベントリスナーを削除
          if (customMarker.boundsListener) {
            google.maps.event.removeListener(customMarker.boundsListener);
          }
          if (customMarker.zoomListener) {
            google.maps.event.removeListener(customMarker.zoomListener);
          }

          // DOM要素を削除
          if (customMarker.customInfoWindow.parentNode) {
            customMarker.customInfoWindow.parentNode.removeChild(
              customMarker.customInfoWindow
            );
          }

          // 参照をクリア
          customMarker.customInfoWindow = null;
          customMarker.boundsListener = null;
          customMarker.zoomListener = null;
        }
      });

      // カスタムマーカーを配列に保存
      this.markers.push({
        element: customMarker,
        position: position,
        name: dogrun.name,
        customInfoWindow: null,
        boundsListener: null,
        zoomListener: null,
      });

    } finally {
      // console.warnを元に戻す
      console.warn = originalWarn;
    }
  }
}

// GoogleMapsMapクラスのインスタンスを作成
const googleMaps = new GoogleMapsMap();
