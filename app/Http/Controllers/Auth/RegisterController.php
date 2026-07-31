<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\RegisterRequest;

class RegisterController extends Controller
{
    //登録フォームの表示
    public function showRegistrationForm() {
        return view('auth.register');
    }

    //登録処理
    public function register(RegisterRequest $request) {
        $validatedData = $request->validated();

        //ユーザーの作成
        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => $validatedData['password'], //castで自動ハッシュ化済み
        ]);

        //ログイン処理
        Auth::login($user);

        //登録後はホーム画面にリダイレクト
        return redirect()->route('home');
    }
}
