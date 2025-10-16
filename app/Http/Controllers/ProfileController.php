<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UpdateProfileRequest;
use App\Http\Requests\PasswordUpdateRequest;

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
    public function update(UpdateProfileRequest $request)
    {
        $user = Auth::user();

        DB::beginTransaction();
        try {
            $validated = $request->validated();

            // プロフィール画像がある場合のみ保存
            if ($request->hasFile('profile_image')) {
                $path = $request->file('profile_image')->store('profiles', 'public');
                $user->profile_image = $path;
            }

            // 残りの項目を更新
            $user->fill($validated)->save();

            DB::commit();
            return back()->with('success', 'プロフィールを更新しました。');
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('プロフィール更新エラー: ' . $e->getMessage());
            return back()->with('error', 'プロフィールの更新に失敗しました。');
        }
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
    public function updatePassword(PasswordUpdateRequest $request)
    {
        $user = Auth::user();

        // 現在のパスワード確認
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => '登録されているパスワードと異なります']);
        }

        DB::beginTransaction();
        try {
            $user->password = Hash::make($request->new_password);
            $user->save();

            DB::commit();
            return redirect()->route('profile.edit')->with('success', 'パスワードを変更しました');
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('パスワード更新エラー: ' . $e->getMessage());
            return back()->with('error', 'パスワードの更新に失敗しました。');
        }
    }
}