<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Place;

class ApiPlaceController extends Controller
{

    public function __construct()
    {
        // $this->middleware('auth:user');
    }

    public function all()
    {
        $placeAll = Place::all();
        $encode_array = json_encode($placeAll, JSON_UNESCAPED_UNICODE);
        return $encode_array;
    }

    public function yamaguchi()
    {
        $place_yamaguchi = Place::tag("yamaguchi")->get();
        $encode_array = json_encode($place_yamaguchi, JSON_UNESCAPED_UNICODE);
        return $encode_array;
    }
    public function hagi()
    {
        $place_hagi = Place::tag("hagi")->get();
        $encode_array = json_encode($place_hagi, JSON_UNESCAPED_UNICODE);
        return $encode_array;
    }
    public function syuunan()
    {
        $place_syuunan = Place::tag("syuunan")->get();
        $encode_array = json_encode($place_syuunan, JSON_UNESCAPED_UNICODE);
        return $encode_array;
    }
    public function shimonoseki()
    {
        $place_shimonoseki = Place::tag("shimonoseki")->get();
        $encode_array = json_encode($place_shimonoseki, JSON_UNESCAPED_UNICODE);
        return $encode_array;
    }
    public function houhu()
    {
        $place_houhu = Place::tag("houhu")->get();
        $encode_array = json_encode($place_houhu, JSON_UNESCAPED_UNICODE);
        return $encode_array;
    }
    public function ubeonoda()
    {
        $place_ubeonoda = Place::tag("ubeonoda")->get();
        $encode_array = json_encode($place_ubeonoda, JSON_UNESCAPED_UNICODE);
        return $encode_array;
    }
    public function iwakunihikari()
    {
        $place_iwakunihikari = Place::tag("iwakunihikari")->get();
        $encode_array = json_encode($place_iwakunihikari, JSON_UNESCAPED_UNICODE);
        return $encode_array;
    }
}
