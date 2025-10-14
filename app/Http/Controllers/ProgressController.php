<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Classes;
use App\Models\Curriculum;
use App\Models\CurriculumProgress;

class ProgressController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); // ログイン必須
    }

    public function index()
    {
        $user = Auth::user();

        // 学年一覧
        $classes = Classes::orderBy('id')->get();

        // ユーザーの進捗（key: curriculumus_id, val: clear_flg）
        $progressMap = CurriculumProgress::where('users_id', $user->id)
              ->pluck('clear_flg', 'curriculums_id');

        // 学年ごとの表示データ
        $progressData = $classes->map(function ($class) use ($progressMap) {
            $curriculums = Curriculum::where('grade_id', $class->id)
                ->orderBy('id')->get()
                ->map(function ($c) use ($progressMap) {
                    return [
                        'title'   => $c->title,
                        'cleared' => (bool)($progressMap[$c->id] ?? false),
                    ];
                });

            return [
                'class_name'  => $class->name,
                'curriculums' => $curriculums,
            ];
        });

        return view('progress.index', compact('user', 'progressData'));
    }
}
