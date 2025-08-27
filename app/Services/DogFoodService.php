<?php

namespace App\Services;

use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;
use Illuminate\Support\Facades\Log;


class DogFoodService
{
    public function amazon_scrape()
    {
        // 環境判定の詳細ログ
        $environment = app()->environment();
        $appEnv = config('app.env');
        $appDebug = config('app.debug');
        
        Log::info('Environment details:', [
            'app()->environment()' => $environment,
            'config(app.env)' => $appEnv,
            'config(app.debug)' => $appDebug
        ]);
        
        // 本番環境またはproduction環境ではスクレイピングを試行
        if ($environment === 'production' || $appEnv === 'production') {
            Log::info('Production environment detected, attempting scraping');
            return $this->performAmazonScraping();
        } else {
            Log::info('Non-production environment detected, using mock data');
            return $this->getMockData();
        }
    }
    
    private function performAmazonScraping()
    {
        try {
            $url = 'https://www.amazon.co.jp/gp/bestsellers/pet-supplies/2155179051';
            
            // 本番環境でのボット検出回避のため、より本物のブラウザに近い設定
            $client = new Client([
                'timeout' => 30,
                'connect_timeout' => 10,
                'verify' => false, // SSL証明書の検証を無効化（本番環境での問題を回避）
                'allow_redirects' => [
                    'max' => 5,
                    'strict' => false,
                    'referer' => true,
                    'protocols' => ['http', 'https']
                ],
                'headers' => [
                    'User-Agent' => $this->getRandomUserAgent(),
                    'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9',
                    'Accept-Language' => 'ja-JP,ja;q=0.9,en-US;q=0.8,en;q=0.7',
                    'Accept-Encoding' => 'gzip, deflate, br',
                    'Connection' => 'keep-alive',
                    'Upgrade-Insecure-Requests' => '1',
                    'Cache-Control' => 'no-cache',
                    'Pragma' => 'no-cache',
                    'Sec-Fetch-Dest' => 'document',
                    'Sec-Fetch-Mode' => 'navigate',
                    'Sec-Fetch-Site' => 'none',
                    'Sec-Fetch-User' => '?1',
                    'DNT' => '1'
                ]
            ]);
            
            // リファラーページを先にアクセスしてから本命のページにアクセス
            $refererUrl = 'https://www.amazon.co.jp/';
            $client->request('GET', $refererUrl);
            
            // 少し待機してから本命のページにアクセス
            usleep(500000); // 0.5秒待機
            
            Log::info('Attempting to scrape Amazon URL: ' . $url);
            $response = $client->request('GET', $url);
            
            if ($response->getStatusCode() !== 200) {
                throw new \Exception('HTTP status: ' . $response->getStatusCode());
            }
            
            $html = $response->getBody()->getContents();
            
            // レスポンスの内容をログに記録（デバッグ用）
            Log::info('Amazon scraping response length: ' . strlen($html));
            Log::info('Amazon scraping response preview: ' . substr($html, 0, 500));
            
            // HTMLが空でないかチェック
            if (empty($html)) {
                throw new \Exception('Empty HTML response received');
            }
            
            // ボット検出ページかどうかチェック
            if (strpos($html, 'captcha') !== false || 
                strpos($html, 'robot') !== false || 
                strpos($html, 'unusual traffic') !== false ||
                strpos($html, 'To discuss automated access') !== false) {
                throw new \Exception('Bot detection page detected');
            }
            
            $crawler = new Crawler($html);
            $count = 0;
            $items = [];

            // #gridItemRoot の要素ごとに処理
            $crawler->filter('#gridItemRoot')->slice(0, 15)->each(function ($node) use ($url, &$count, &$items) {
                try {
                    $count++;
                    
                    // 各要素の存在確認
                    $titleNode = $node->filter('._cDEzb_p13n-sc-css-line-clamp-2_EWgCb');
                    $priceNode = $node->filter('._cDEzb_p13n-sc-price_3mJ9Z');
                    $imgNode = $node->filter('img');
                    $linkNode = $node->filter('a');
                    
                    if ($titleNode->count() === 0 || $priceNode->count() === 0) {
                        return;
                    }
                    
                    $title = $titleNode->text();
                    $price = $priceNode->text();
                    
                    // img 要素の src 属性を取得
                    $imgSrc = $imgNode->count() > 0 ? $imgNode->attr('src') : '';
                    
                    // リンクの取得と絶対URL変換
                    $link = '';
                    if ($linkNode->count() > 0) {
                        $link = $linkNode->attr('href');
                        if ($link) {
                            $link = $this->convertToAbsoluteUrl($url, $link);
                        }
                    }

                    // アイテムを配列に追加
                    $items[] = [
                        'title' => $title,
                        'price' => $price,
                        'img' => $imgSrc,
                        'url' => $link,
                        'count' => $count,
                    ];
                    
                } catch (\Exception $e) {
                    Log::warning('Item processing error: ' . $e->getMessage());
                    // エラーが発生しても処理を継続
                }
            });

            // データが取得できたかチェック
            if (empty($items)) {
                Log::warning('No items found in Amazon scraping. HTML length: ' . strlen($html));
                throw new \Exception('No items found in the scraped content');
            }

            Log::info('Amazon scraping successful. Found ' . count($items) . ' items');
            return $items;
            
        } catch (\Exception $e) {
            Log::error('Amazon scraping failed: ' . $e->getMessage());
            // スクレイピングが失敗した場合はフォールバックデータを返す
            return $this->getFallbackData();
        }
    }

    public function yahoo_scrape()
    {
        try {
            $url = 'https://shopping.yahoo.co.jp/ranking/keyword/?p=ドッグフード';

            $client = new Client([
                'timeout' => 10,
                'headers' => [
                    'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36'
                ]
            ]);

            $response = $client->request('GET', $url);

            if ($response->getStatusCode() !== 200) {
                throw new \Exception('HTTP status: ' . $response->getStatusCode());
            }

            $crawler = new Crawler($response->getBody()->getContents());
            $count = 0;
            $items = [];

            // .LoopList__item の要素ごとに処理
            $crawler->filter('.LoopList__item')->slice(0, 15)->each(function ($node) use ($url, &$count, &$items) {
                try {
                    $count++;
                    
                    // 各要素の存在確認
                    $titleNode = $node->filter('.SearchResultItemTitle_SearchResultItemTitle__name__BwTpC');
                    $priceNode = $node->filter('.SearchResultItemPrice_SearchResultItemPrice__value__G8pQV');
                    $imgNode = $node->filter('img');
                    $linkNode = $node->filter('a');
                    
                    if ($titleNode->count() === 0 || $priceNode->count() === 0) {
                        return;
                    }
                    
                    $title = $titleNode->text();
                    $price = $priceNode->text();

                    // img 要素の src 属性を取得
                    $imgSrc = $imgNode->count() > 0 ? $imgNode->attr('src') : '';

                    // リンクの取得と絶対URL変換
                    $link = '';
                    if ($linkNode->count() > 0) {
                        $link = $linkNode->attr('href');
                        if ($link) {
                            $link = $this->convertToAbsoluteUrl($url, $link);
                        }
                    }

                    // アイテムを配列に追加
                    $items[] = [
                        'title' => $title,
                        'price' => $price,
                        'img' => $imgSrc,
                        'url' => $link,
                        'count' => $count,
                    ];
                    
                } catch (\Exception $e) {
                    // エラーが発生しても処理を継続
                }
            });

            return $items;
            
        } catch (\Exception $e) {
            return [];
        }
    }

    private function convertToAbsoluteUrl($baseUrl, $link)
    {
        return (string) \GuzzleHttp\Psr7\UriResolver::resolve(
            new \GuzzleHttp\Psr7\Uri($baseUrl),
            new \GuzzleHttp\Psr7\Uri($link)
        );
    }
    
    private function getRandomUserAgent()
    {
        $userAgents = [
            'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
            'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
            'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/121.0',
            'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.1 Safari/605.1.15',
            'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36'
        ];
        
        return $userAgents[array_rand($userAgents, 1)];
    }
    
    private function getFallbackData()
    {
        // スクレイピングが失敗した場合のフォールバックデータ
        return [
            [
                'title' => 'ドッグフード（サンプル）',
                'price' => '￥1,000',
                'img' => '/images/dogs/default.jpg',
                'url' => 'https://www.amazon.co.jp/',
                'count' => 1,
            ]
        ];
    }
    
    private function getMockData()
    {
        // ローカル環境用のモックデータ
        return [
            [
                'title' => 'プレミアムドッグフード チキン味',
                'price' => '￥2,980',
                'img' => '/images/dogs/default.jpg',
                'url' => 'https://www.amazon.co.jp/',
                'count' => 1,
            ],
            [
                'title' => 'ナチュラルドッグフード サーモン味',
                'price' => '￥3,280',
                'img' => '/images/dogs/default.jpg',
                'url' => 'https://www.amazon.co.jp/',
                'count' => 2,
            ],
            [
                'title' => 'グレインフリードッグフード ビーフ味',
                'price' => '￥2,580',
                'img' => '/images/dogs/default.jpg',
                'url' => 'https://www.amazon.co.jp/',
                'count' => 3,
            ]
        ];
    }
}
