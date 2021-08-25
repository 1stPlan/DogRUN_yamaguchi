<?php

namespace App\Services;

use Symfony\Component\DomCrawler\Crawler;
use Mockery;
use GuzzleHttp\Client;


class DogFoodService
{
    public function amazon_scrape()
    {
        $url = "https://www.amazon.co.jp/gp/bestsellers/pet-supplies/2155179051";

        $client = new Client();
        $response = $client->request('GET', $url);
        $crawler = new Crawler($response->getBody()->getContents());
        $count = 0;

        // #gridItemRoot の要素ごとに処理
        $items = $crawler->filter('#gridItemRoot')->slice(0, 15)->each(function ($node) use ($url, &$count) {
            // テキストの取得
            
            $count++;
            $title = $node->filter('._cDEzb_p13n-sc-css-line-clamp-2_EWgCb')->text();
            $price = $node->filter('._cDEzb_p13n-sc-price-animation-wrapper_3PzN2')->text();

            // img 要素の src 属性を取得
            $imgSrc = $node->filter('img')->attr('src');

            $link = $node->filter('a')->attr('href');
            if ($link) {
                // 絶対URLに変換
                $url = $this->convertToAbsoluteUrl($url, $link);
            }

            // テキストと画像URLを配列で返す
            return [
                'title' => $title,
                'price' => $price,
                'img' => $imgSrc,
                'url' => $url,
                'count' => $count,
            ];
        });

        return $items;
    }

    public function yahoo_scrape()
    {
        $url = "https://shopping.yahoo.co.jp/ranking/keyword/?p=ドッグフード";

        $client = new Client();
        $response = $client->request('GET', $url);
        $crawler = new Crawler($response->getBody()->getContents());

        // #gridItemRoot の要素ごとに処理
        $items = $crawler->filter('.LoopList__item')->slice(0, 15)->each(function ($node) use ($url, &$count) {
            // テキストの取得
            $count++;
            $title = $node->filter('.SearchResultItemTitle_SearchResultItemTitle__name__BwTpC')->text();

            $price =  $node->filter('.SearchResultItemPrice_SearchResultItemPrice__value__G8pQV')->text();

            // img 要素の src 属性を取得
            $imgSrc = $node->filter('img')->attr('src');

            $link = $node->filter('a')->attr('href');
            if ($link) {
                // 絶対URLに変換
                $url = $this->convertToAbsoluteUrl($url, $link);
            }

            // テキストと画像URLを配列で返す
            return [
                'title' => $title,
                'price' => $price,
                'img' => $imgSrc,
                'url' => $url,
                'count' => $count,
            ];
        });

        return $items;
    }

    private function convertToAbsoluteUrl($baseUrl, $link)
    {
        return (string) \GuzzleHttp\Psr7\UriResolver::resolve(
            new \GuzzleHttp\Psr7\Uri($baseUrl),
            new \GuzzleHttp\Psr7\Uri($link)
        );
    }
}
