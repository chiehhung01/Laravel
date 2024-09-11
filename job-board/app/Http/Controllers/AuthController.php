<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{    
    public function create()
    {
        return view('auth.create');
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $credentials = $request->only('email', 'password');
        $remember = $request->filled('remember');

        //Laravel 的 Auth::attempt 方法進行身份驗證
        //如果身份驗證成功，intended('/') 將用戶重定向到他們原來試圖訪問的頁面，如果沒有先前的訪問頁面，則將重定向到默認的首頁(/)
        if(Auth::attempt($credentials,$remember)){
            return redirect()->intended('/');
        }else{
            return redirect()->back()
            ->with('error', 'Invalid credentials');
        }
    }

    public function destroy()
    {
        Auth::logout();
        // 使當前會話失效，通常用於清除用戶的 session 資訊
        request()->session()->invalidate();
        // 重新生成 CSRF token，有助於提高應用程式的安全性
        request()->session()->regenerateToken();

        return redirect('/');
    }
}
