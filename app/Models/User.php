<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * 一括代入可能な属性
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'name_kana',
        'email',
        'password',
        'profile_image',
        'grade_id',
    ];

    /**
     * シリアライズ時に隠す属性
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * 型変換する属性
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * 学年（クラス）とのリレーション
     * ユーザーは1つのクラスに属する
     */
    public function grade()
    {
        return $this->belongsTo(Classes::class, 'grade_id');
    }

    /**
     * カリキュラム進捗とのリレーション
     * ユーザーは複数のカリキュラム進捗を持つ
     */
    public function curriculumProgress()
    {
        return $this->hasMany(CurriculumProgress::class, 'users_id');
    }

    /**
     * プロフィール画像のURLを取得
     * なければデフォルト画像を返す
     */
    public function getProfileImageUrlAttribute()
    {
        if ($this->profile_image) {
            return asset('storage/' . $this->profile_image);
        }
        return asset('images/default-avatar.png');
    }
}
