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

    public function index()
    {
        $user = Auth::user();

        // 学年一覧
        $classes = Classes::orderBy('id')->get();

        // 進捗マップ取得（モデルのメソッドを使用）
        $progressMap = CurriculumProgress::getProgressMapByUser($user->id);

        // 学年ごとのデータ生成
        $progressData = $this->buildProgressData($classes, $progressMap);

        return view('progress.index', compact('user', 'progressData'));
    }

    /**
     * 学年ごとの授業進捗データを作成
     *
     * @param \Illuminate\Support\Collection $classes
     * @param \Illuminate\Support\Collection $progressMap
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