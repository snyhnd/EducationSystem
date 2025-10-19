<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;

class AdminBannerController extends Controller
{
    /** 一覧 */
    public function index()
    {
        $banners = Banner::getAllBanners();
        return view('admin.banners.index', compact('banners'));
    }

    /** 登録 */
    public function store(Request $request)
    {
        $request->validate([
            'images'   => ['required', 'array'],
            'images.*' => ['file', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        Banner::registerImages($request->file('images'));

        return back()->with('success', 'バナーを登録しました');
    }

    /** 削除 */
    public function destroy(Banner $banner)
    {
        $banner->deleteWithFile();
        return back()->with('success', 'バナーを削除しました');
    }
}
