<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class ScrapingController extends Controller
{
    public function amazon_scrape()
    {
        try {
            $service = app()->make('DogFoodService');
            $amazon = $service->amazon_scrape();
            
            if (empty($amazon)) {
                return response($this->createJsonResponse(false, 'データが取得できませんでした', []))
                    ->header('Content-Type', 'application/json; charset=utf-8');
            }
            
            return response($this->createJsonResponse(true, '', $amazon))
                ->header('Content-Type', 'application/json; charset=utf-8');
                
        } catch (\Exception $e) {
            Log::error('Amazon scraping error: ' . $e->getMessage());
            
            return response($this->createJsonResponse(false, 'サーバーエラーが発生しました', []))
                ->header('Content-Type', 'application/json; charset=utf-8')
                ->setStatusCode(500);
        }
    }

    public function yahoo_scrape()
    {
        try {
            $service = app()->make('DogFoodService');
            $yahoo = $service->yahoo_scrape();
            
            if (empty($yahoo)) {
                return response($this->createJsonResponse(false, 'データが取得できませんでした', []))
                    ->header('Content-Type', 'application/json; charset=utf-8');
            }
            
            return response($this->createJsonResponse(true, '', $yahoo))
                ->header('Content-Type', 'application/json; charset=utf-8');
                
        } catch (\Exception $e) {
            Log::error('Yahoo scraping error: ' . $e->getMessage());
            
            return response($this->createJsonResponse(false, 'サーバーエラーが発生しました', []))
                ->header('Content-Type', 'application/json; charset=utf-8')
                ->setStatusCode(500);
        }
    }
    
    private function createJsonResponse($success, $message, $data)
    {
        return json_encode([
            'success' => $success,
            'message' => $message,
            'data' => $data
        ], JSON_UNESCAPED_UNICODE);
    }
}
