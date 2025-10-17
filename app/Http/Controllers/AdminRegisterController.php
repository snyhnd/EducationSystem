<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

Admin::create([
    'username' => $v['username'],
    'kana'     => $v['kana'],
    'email'    => $v['email'],
    'password' => Hash::make($v['password']), // ★ ここ重要
]);

class AdminRegisterController extends Controller
{
    // 管理ユーザー登録フォームの表示
    public function create()
    {
        return view('admin.register');  // ← ビューを返す
    }

    // 登録処理（仮）
    public function store(Request $request)
    {
        return response('store ok', 200);
    }
}
