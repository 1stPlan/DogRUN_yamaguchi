<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Route;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    protected $user_route  = 'login';
    protected $admin_route = 'admin.login';

    protected function redirectTo($request)
    {
        // ルーティングに応じて未ログイン時のリダイレクト先を振り分ける
        if (!$request->expectsJson()) {
            if (Route::is('admin.*')) {
                return route($this->admin_route);
            } else {
                return route($this->user_route);
            }
        }
    }
}
