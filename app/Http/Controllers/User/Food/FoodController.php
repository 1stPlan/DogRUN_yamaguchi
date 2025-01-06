<?php

namespace App\Http\Controllers\User\Food;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class FoodController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth:user');
    }

    public function index()
    {
        return view('user.food.food');
    }
}
