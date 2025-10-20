<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Banner extends Model
{
    protected $fillable = ['image', 'sort'];

    /**
     * 表示用のURLを返す
     * (storageリンク済み前提)
     */
    public function getUrlAttribute(): string
    {
        return asset('storage/' . $this->image);
    }

    /**
     * 並び順付きで全バナーを取得
     * Controllerから this で呼べる
     */
    public static function getAllBanners()
    {
        return self::orderBy('sort')->orderBy('id')->get();
    }

    /**
     * バナー画像を登録
     */
    public static function registerImages(array $files)
    {
        foreach ($files as $file) {
            $path = $file->store('banners', 'public');
            self::create(['image' => $path]);
        }
    }

    /**
     * 画像削除（ファイルも一緒に）
     */
    public function deleteWithFile()
    {
        if (Storage::disk('public')->exists($this->image)) {
            Storage::disk('public')->delete($this->image);
        }
        $this->delete();
    }
}
