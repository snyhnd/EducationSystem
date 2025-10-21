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
        $this->middleware('auth');
    }

    /**
     * 授業進捗一覧ページ
     */
    public function index()
    {
        $user = Auth::user();

        // 学年一覧（Classesテーブル）
        $classes = Classes::orderBy('id')->get();

        // 進捗マップ取得（CurriculumProgressモデルのメソッドを利用）
        $progressMap = CurriculumProgress::getProgressMapByUser($user->id);

        // 学年ごとのデータ生成
        $progressData = $this->buildProgressData($classes, $progressMap);

        return view('progress.index', compact('user', 'progressData'));
    }

    /**
     * 授業詳細ページ（各授業タイトルリンク先）
     */
    public function show($grade, $lesson)
    {
        return view('progress.lesson', compact('grade', 'lesson'));
    }

    /**
     * 学年ごとの授業進捗データを作成
     *
     * @param \Illuminate\Support\Collection $classes
     * @param array $progressMap
     * @return \Illuminate\Support\Collection
     */
    private function buildProgressData($classes, $progressMap)
    {
        return $classes->map(function ($class) use ($progressMap) {
            $curriculums = Curriculum::where('grade_id', $class->id)
                ->orderBy('id')
                ->get()
                ->map(function ($curriculum) use ($progressMap) {
                    return [
                        'title'   => $curriculum->title,
                        'cleared' => (bool)($progressMap[$curriculum->id] ?? false),
                    ];
                });

            return [
                'class_name'  => $class->name,
                'curriculums' => $curriculums,
            ];
        });
    }
}
