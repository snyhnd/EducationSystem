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
    /**
     * カリキュラム一覧表示（通常 or Ajax）
     */
    public function index(Request $request)
    {
        return $this->renderCurriculumList($request);
    }

    public function partial(Request $request)
    {
        return $this->renderCurriculumList($request, true);
    }

    /**
     * 共通処理：カリキュラム一覧の取得と描画
     *
     * @param Request $request
     * @param bool $isAjax
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    private function renderCurriculumList(Request $request, bool $isAjax = false)
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

        $current = Carbon::create($year, $month);
        $prev = $current->copy()->subMonth();
        $next = $current->copy()->addMonth();

        $gradeClasses = config('grades.classes');


        $lessons = Curriculum::forSchedule($year, $month, $grade_id)->get();
        $userId = Auth::id();
        $clearedCurriculumIds = CurriculumProgress::getClearedCurriculumIdsByUser($userId);
        $clearedGradeIds = Curriculum::getClearedGradeIdsByCurriculumIds($clearedCurriculumIds);
        $maxGradeId = Auth::user()->grade_id ?? 1;

        $data = compact(
            'year',
            'month',
            'grade',
            'current',
            'prev',
            'next',
            'gradeClasses',
            'lessons',
            'maxGradeId',
            'grades'
        );

        if ($isAjax) {
            $html = view('user.layouts.curriculum_list', $data)->render();
            return response()->json(['html' => $html]);
        }

        return view('user.layouts.curriculum_list', $data);
    }

    /**
     * 配達画面表示
     */
    public function delivery($id, Request $request)
    {
        $lesson = Curriculum::findOrFail($id);
        $grade = $request->query('grade');

        return view('user.layouts.delivery', compact('lesson', 'grade'));
    }
}
