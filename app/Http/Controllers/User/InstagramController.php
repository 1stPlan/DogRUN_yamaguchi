<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class InstagramController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth:user');
    }
    public function index()
    {
        // Instagram投稿を取得
        $instagramPosts = $this->getInstagramPosts();

        return view('user.instagram.index')->with([
            'data' => $instagramPosts
        ]);
    }

    // Instagram投稿を取得
    public function getInstagramPosts()
    {
        try {
            $accessToken = env('INSTAGRAM_ACCESS_TOKEN');
            $userId = env('INSTAGRAM_USER_ID');

            if (!$accessToken || !$userId) {
                Log::warning('Instagram credentials not configured');
                return collect();
            }

            // Instagram Graph API（Instagramログイン用）を使用
            // graph.instagram.comを使用（graph.facebook.comではない）
            $url = "https://graph.instagram.com/v22.0/{$userId}/media?fields=id,caption,media_type,media_url,thumbnail_url,permalink,timestamp,like_count,comments_count&access_token={$accessToken}&limit=4";

            $curl = curl_init();
            curl_setopt_array($curl, [
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTPHEADER => [
                    'Accept: application/json',
                    'User-Agent: DogRUN-App/1.0'
                ]
            ]);

            $response = curl_exec($curl);
            $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            curl_close($curl);

            if ($httpCode !== 200) {
                Log::error('Instagram Graph API error', ['http_code' => $httpCode, 'response' => $response]);
                return collect();
            }

            $data = json_decode($response, true);

            if (!isset($data['data'])) {
                Log::error('Invalid Instagram Graph API response', ['response' => $data]);
                return collect();
            }

            return collect($data['data']);
        } catch (\Exception $e) {
            Log::error('Instagram API exception', ['error' => $e->getMessage()]);
            return collect();
        }
    }
}
