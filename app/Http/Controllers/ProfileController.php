<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Http\Requests\ProfileUpdateRequest;
use App\Http\Requests\PasswordUpdateRequest;
use App\Models\User;
use App\Http\Requests\UpdateProfileRequest;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * プロフィール編集画面を表示
     */
    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    /**
     * プロフィールを更新
     */
    public function update(Request $request)
{
    $user = Auth::user();

    $validated = $request->validate([
        'name'       => 'required|string|max:20',
        'name_kana'  => ['required', 'regex:/^[ァ-ヶー　]+$/u', 'max:20'],
        'email'      => 'required|email|max:255',
        'profile_image' => 'nullable|mimes:jpg,jpeg,png|max:2048',
    ], [
        'name.required' => 'この項目は入力必須です',
        'name.max' => '20文字以内にしてください',
        'name_kana.required' => 'この項目は入力必須です',
        'name_kana.regex' => 'カタカナで入力してください',
        'name_kana.max' => '20文字以内にしてください',
        'email.required' => 'この項目は入力必須です',
        'email.email' => 'メールアドレスの形式で入力してください',
        'email.max' => '255文字以内にしてください',
        'profile_image.mimes' => '指定されたファイル形式ではありません（jpgまたはpng）',
    ]);

    if ($request->hasFile('profile_image')) {
        $path = $request->file('profile_image')->store('profiles', 'public');
        $user->profile_image = $path;
    }

    $user->fill($validated)->save();

    return back()->with('success', 'プロフィールを更新しました。');
}

    /**
     * パスワード変更画面を表示
     */
    public function editPassword()
    {
        return view('profile.password');
    }

    /**
     * パスワードを更新
     */
    public function updatePassword(Request $request)
{
    $request->validate([
        'current_password' => ['required', 'string', 'min:8', 'max:30'],
        'new_password' => ['required', 'string', 'min:8', 'max:30', 'confirmed'],
    ], [
        'current_password.required' => 'この項目は入力必須です',
        'new_password.required' => 'この項目は入力必須です',
        'new_password.min' => 'パスワードは8文字以上30文字以内で入力してください',
        'new_password.max' => 'パスワードは8文字以上30文字以内で入力してください',
        'new_password.confirmed' => '入力したパスワードと異なります',
    ]);

    if (!Hash::check($request->current_password, Auth::user()->password)) {
        return back()->withErrors(['current_password' => '登録されているパスワードと異なります']);
    }

    $user = Auth::user();
    $user->password = Hash::make($request->new_password);
    $user->save();

    return redirect()->route('profile.edit')->with('success', 'パスワードを変更しました');
}
}