<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\LoginRequest;

class LoginController extends Controller
{
    public function showLoginForm() {
        return view('auth.login');
    }

    public function login(LoginRequest $request) {
        //バリデーション
        $credentials = $request->validated();

        //認証処理
        if (Auth::attempt($credentials)) {
            // セッション固定化対策
            $request->session()->regenerate();

            // ログイン前にアクセスしようとしていたページにリダイレクト。なければホーム画面
            return redirect()->intended(route('home'));
        }

        // 認証に失敗した場合、エラーメッセージを返してログイン画面にリダイレクト。
        // パスワードは保持しないようにするため、onlyInput('email')でメールアドレスのみ保持する。
        return back()->withErrors([
            'email' => 'メールアドレスまたはパスワードが正しくありません。',
        ])->onlyInput('email');
    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
