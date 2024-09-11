<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;



class LocaleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
     $locale = null;
    // 檢查是否已經通過身份驗證並且 Session 中不存在 locale 數據
     if(Auth::check() && !Session::has('locale')){
        $locale = $request->user()->locale; //user model取得locale
        Session::put('locale',$locale);
     }
    // 檢查請求中是否存在 locale 參數
     if($request->has('locale')){
        $locale = $request->get('locale');
        Session::put('locale',$locale);
     }

     $locale = Session::get('locale');

     if($locale === null){
        $locale = config('app.fallback_locale');
     }
     App::setLocale($locale);

     return $next($request);
    }
}
