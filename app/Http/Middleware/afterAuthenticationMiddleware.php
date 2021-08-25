<?php


namespace App\Http\Middleware;
use Closure;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


class afterAuthenticationMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = Auth::user();

        if ($user->name == "" && $user->kana == "") {
            return redirect('/add_information');
        }
        return $next($request);
    }

}