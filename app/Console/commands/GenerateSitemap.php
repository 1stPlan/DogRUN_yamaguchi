<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use App\Models\Place;

class GenerateSitemap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemap:generate';

    /**
     * The console command description.
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

        $baseUrl = config('app.url');
        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

        // 静的ページ
        $staticPages = [
            '/' => '1.0',
            '/login' => '0.8',
            '/register' => '0.8',
            '/user/place' => '0.9',
            '/user/food' => '0.8',
            '/user/event' => '0.8',
            '/contact' => '0.7',
        ];

        foreach ($staticPages as $url => $priority) {
            $xml .= $this->generateUrlElement($baseUrl . $url, $priority, 'weekly');
        }

        // 動的ページ（ドッグラン詳細）
        $places = Place::all();
        foreach ($places as $place) {
            $url = $baseUrl . '/user/place/detail/' . $place->id;
            $xml .= $this->generateUrlElement($url, '0.7', 'monthly');
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
