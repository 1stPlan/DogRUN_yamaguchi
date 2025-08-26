<?php

namespace App\Services;

use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;
use Illuminate\Support\Facades\Log;

class DogFoodService
{
    public function amazon_scrape()
    {
        $maxRetries = 3;
        $retryCount = 0;
        
        while ($retryCount < $maxRetries) {
            try {
                $url = 'https://www.amazon.co.jp/gp/bestsellers/pet-supplies/2155179051';

                $client = new Client([
                    'timeout' => 30,
                    'connect_timeout' => 10,
                    'headers' => [
                        'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36',
                        'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
                        'Accept-Language' => 'ja,en-US;q=0.7,en;q=0.3',
                        'Accept-Encoding' => 'gzip, deflate',
                        'Connection' => 'keep-alive',
                        'Upgrade-Insecure-Requests' => '1',
                    ]
                ]);
                
                $response = $client->request('GET', $url);
                if ($response->getStatusCode() !== 200) {
                    throw new \Exception('HTTP status: ' . $response->getStatusCode());
                }
                
                $crawler = new Crawler($response->getBody()->getContents());
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
                        // エラーが発生しても処理を継続
                    }
                });

                return $items;
            
            } catch (\Exception $e) {
                $retryCount++;
    
                if ($retryCount >= $maxRetries) {
                    return [];
                }
                
                // リトライ前に少し待機
                sleep(2);
            }
        }
        
        return [];
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
}
