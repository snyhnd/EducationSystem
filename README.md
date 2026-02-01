# EducationSystem

学生の学年ごと講座がある教育支援システムです。Laravel を用いて構築しました。

## 使用技術

- PHP 8.x  
- Laravel 10  
- MySQL  
- Blade  
- Bootstrap

## 主な機能

- 学生の登録・編集・削除  
- 科目の登録・編集・削除  
- 受講したか確認するシステム 


## セットアップ方法

```bash
git clone https://github.com/snyhnd/EducationSystem.git
cd EducationSystem
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan serve
