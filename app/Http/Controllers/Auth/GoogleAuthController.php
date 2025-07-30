<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    /**
     * Google認証を開始
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Google認証コールバック
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            // ユーザーを取得または作成
            $user = $this->findOrCreateUser($googleUser);

            // ログイン
            Auth::login($user);

            return redirect()->intended('/user/dashboard')->with('success', 'Googleでログインしました！');

        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Google認証に失敗しました');
        }
    }

    /**
     * ユーザーを取得または作成
     */
    private function findOrCreateUser($googleUser)
    {
        // Google IDでユーザーを検索
        $user = User::where('google_id', $googleUser->getId())->first();

        if (!$user) {
            // Google Emailでユーザーを検索
            $user = User::where('email', $googleUser->getEmail())->first();

            if ($user) {
                // 既存ユーザーのGoogle情報を更新
                $user->update([
                    'google_id' => $googleUser->getId(),
                    'google_email' => $googleUser->getEmail(),
                    'avatar' => $googleUser->getAvatar(),
                ]);
            } else {
                // 新しいユーザーを作成
                $user = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'password' => Hash::make(Str::random(16)), // ランダムパスワード
                    'google_id' => $googleUser->getId(),
                    'google_email' => $googleUser->getEmail(),
                    'avatar' => $googleUser->getAvatar(),
                ]);
            }
        }

        return $user;
    }
}