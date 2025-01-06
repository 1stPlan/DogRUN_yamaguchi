<?php

namespace App\Http\Controllers\User\Place;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PlaceController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth:user');
    }

    public function index()
    {
        return view('user.place.place');
    }

    public function result()
    {
        $uri = rtrim($_SERVER['REQUEST_URI'], '/');
        $place_key = substr($uri, strrpos($uri, '/') + 1);

        session_start();
        // セッション情報の保存
        $_SESSION['place_key'] = $place_key;

        if ($place_key == 'yamaguchi') {
            $place_area = '山口市';
        } elseif ($place_key == 'shimonoseki') {
            $place_area = '下関市';
        } elseif ($place_key == 'houhu') {
            $place_area = '防府市';
        } elseif ($place_key == 'hagi') {
            $place_area = '萩市';
        } elseif ($place_key == 'syuunan') {
            $place_area = '周南市';
        } elseif ($place_key == 'ubeonoda') {
            $place_area = '宇部市・小野田市';
        } elseif ($place_key == 'iwakunihikari') {
            $place_area = '岩国市・光市';
        } elseif ($place_key == 'all') {
            $place_area = '山口県全域';
        } else {
            $place_area = '';
        }

        return view('user.place.result')
            ->with([
                'place_area' => $place_area,
            ]);
    }
}
