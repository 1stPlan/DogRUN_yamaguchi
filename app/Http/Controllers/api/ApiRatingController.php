<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post\Rating;
use Illuminate\Support\Facades\Auth;

class ApiRatingController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth:user');
    }

    public function Rating()
    {
        $ratingAll = Rating::get();
        $ratings = [];

        for ($i = 0; $i < count($ratingAll); $i++) {
            $ratings[$i]['place'] = $ratingAll[$i]['place_id'];
            $ratings[$i]['rating'] = $ratingAll[$i]['rating'];
        }

        $encode_array = json_encode($ratings, JSON_UNESCAPED_UNICODE);

        return $encode_array;
    }
}
