<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Curriculum;
use Illuminate\Support\Facades\Auth;
use App\Models\CurriculumProgress;
use App\Models\Grade;

class CurriculumController extends Controller
{
    // カリキュラム一覧表示
    public function index(Request $request)
    {
        $grades = Grade::all();
        $grade_id = $request->get('grade_id');
        $year = $request->get('year', now()->year);
        $month = $request->get('month', now()->month);
        $grade = $request->get('grade', '小学校1年生');
        $class = $request->get('class');
        if (!$grade_id && $grade) {
    $grade_id = Grade::where('name', $grade)->value('id');
}

        $lessons = Curriculum::forSchedule($year, $month, $grade_id)->get();


        $userId = Auth::id();

        // クリア済みの授業ID一覧
        $clearedCurriculumIds = CurriculumProgress::where('users_id', $userId)
            ->where('clear_flg', 1)
            ->pluck('curriculums_id');

        // それに対応する学年ID一覧（重複なし）
        $clearedGradeIds = Curriculum::whereIn('id', $clearedCurriculumIds)
            ->pluck('grade_id')
            ->unique()
            ->sort();

        // 最大の学年ID（初回ログインなら1年生）
        // $maxGradeId = $clearedGradeIds->max() ?? 1;
        $maxGradeId = Auth::user()->grade_id ?? 1;

        // $maxGradeId = 12;

        return view('user.layouts.curriculum_list', compact(
            'year', 'month', 'grade', 'lessons', 'maxGradeId','grades'
        ));
    }

    // Ajaxで部分描画
    public function partial(Request $request)
    {
        $grades = Grade::all();
        $grade_id = $request->get('grade_id');
        $year = $request->get('year');
        $month = $request->get('month');
        $grade = $request->get('grade');
        $class = $request->get('class');
        if (!$grade_id && $grade) {
    $grade_id = Grade::where('name', $grade)->value('id');
}

        $lessons = Curriculum::forSchedule($year, $month, $grade_id)->get();


        $userId = Auth::id();

        // クリア済みの授業ID一覧
        $clearedCurriculumIds = CurriculumProgress::where('users_id', $userId)
            ->where('clear_flg', 1)
            ->pluck('curriculums_id');

        // それに対応する学年ID一覧（重複なし）
        $clearedGradeIds = Curriculum::whereIn('id', $clearedCurriculumIds)
            ->pluck('grade_id')
            ->unique()
            ->sort();

        // 最大の学年ID（初回ログインなら1年生）
        // $maxGradeId = $clearedGradeIds->max() ?? 1;
        $maxGradeId = Auth::user()->grade_id ?? 1;


        $html = view('user.layouts.curriculum_list', compact(
            'year', 'month', 'grade', 'lessons', 'maxGradeId','grades'
        ))->render();

        return response()->json(['html' => $html]);
    }

    // 配達画面表示
    public function delivery($id, Request $request)
    {
        $lesson = Curriculum::findOrFail($id);
        $grade = $request->query('grade');

        return view('user.layouts.delivery', compact('lesson', 'grade'));

    }
}
