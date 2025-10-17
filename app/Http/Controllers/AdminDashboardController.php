<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function show(Request $request)
    {
        // ざっくりなログイン確認（未ログインならログイン画面へ）
        if (!session()->has('admin_id')) {
            return redirect()->route('admin.login');
        }

        return view('admin.dashboard', [
            'name'  => session('admin_name', '（不明）'),
            'email' => session('admin_email', '（不明）'),
        ]);
    }
}
