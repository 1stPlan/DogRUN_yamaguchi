<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

class ScrapingController extends Controller
{
    public function amazon_scrape()
    {
        $service = app()->make('DogFoodService');
        $amazon = $service->amazon_scrape();
        $encode_array = json_encode($amazon, JSON_UNESCAPED_UNICODE);

        return $encode_array;
    }

    public function yahoo_scrape()
    {
        $service = app()->make('DogFoodService');
        $yahoo = $service->yahoo_scrape();
        $encode_array = json_encode($yahoo, JSON_UNESCAPED_UNICODE);

        return $encode_array;
    }
}
