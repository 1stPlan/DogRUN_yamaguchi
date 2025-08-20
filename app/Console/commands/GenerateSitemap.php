<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use App\Models\Place;
use App\Models\Event\Event;

class GenerateSitemap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemap:generate';

    /**
     * The console console description.
     *
     * @var string
     */
    protected $description = 'Generate sitemap.xml for SEO';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Generating sitemap.xml...');

        // 本番環境のURLを直接指定
        $baseUrl = 'https://dogrun-yamaguchi.com';
        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

        // 静的ページ（優先度を上げて、より詳細な情報を含む）
        $staticPages = [
            '/' => '1.0', // トップページ（最高優先度）
            '/login' => '0.6',
            '/register' => '0.6',
            '/user/place' => '0.9', // ドッグラン検索（高優先度）
            '/user/food' => '0.8', // ドッグフード情報
            '/user/event' => '0.8', // イベント情報
            '/user/contact' => '0.7', // お問い合わせ
            '/user/type' => '0.7', // わんちゃん診断
            '/user/instagram' => '0.6', // Instagram連携
            '/user/privacy-policy' => '0.5', // プライバシーポリシー
            '/user/terms' => '0.5', // 利用規約
        ];

        foreach ($staticPages as $url => $priority) {
            $xml .= $this->generateUrlElement($baseUrl . $url, $priority, 'weekly');
        }

        // 動的ページ（ドッグラン詳細）
        $places = Place::all();
        foreach ($places as $place) {
            $url = $baseUrl . '/place/' . $place->id;
            $xml .= $this->generateUrlElement($url, '0.8', 'monthly');
        }

        // イベント詳細ページ
        $events = \App\Models\Event\Event::all();
        foreach ($events as $event) {
            $url = $baseUrl . '/user/event/' . $event->id;
            $xml .= $this->generateUrlElement($url, '0.7', 'weekly');
        }

        // 投稿詳細ページ（ドッグランのレビュー）
        $posts = \App\Models\Post\Post::with('place')->get();
        foreach ($posts as $post) {
            if ($post->place) {
                $url = $baseUrl . '/posts/' . $post->place->id;
                $xml .= $this->generateUrlElement($url, '0.6', 'monthly');
            }
        }

        $xml .= '</urlset>';

        // sitemap.xmlを保存
        File::put(public_path('sitemap.xml'), $xml);

        $this->info('Sitemap generated successfully at: ' . public_path('sitemap.xml'));
        return 0;
    }

    /**
     * Generate URL element for sitemap
     *
     * @param string $url
     * @param string $priority
     * @param string $changefreq
     * @return string
     */
    private function generateUrlElement($url, $priority, $changefreq)
    {
        return "  <url>\n" .
               "    <loc>{$url}</loc>\n" .
               "    <lastmod>" . date('Y-m-d') . "</lastmod>\n" .
               "    <changefreq>{$changefreq}</changefreq>\n" .
               "    <priority>{$priority}</priority>\n" .
               "  </url>\n";
    }
}
