<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Curriculum;
use Carbon\Carbon;

class TimetableController extends Controller
{
    /**
     * 時間割トップ
     * URL例: /schedule /schedule/2025/10/小学3年生
     */
    public function index($year = null, $month = null, $grade = null)
    {
        // 年月（指定なしなら今月）
        $date = Carbon::createFromDate($year ?? now()->year, $month ?? now()->month, 1);
        $startOfMonth = $date->copy()->startOfMonth();
        $endOfMonth   = $date->copy()->endOfMonth();

        // 学年一覧（固定配列）
        $grades = [
            '小学1年生','小学2年生','小学3年生',
            '小学4年生','小学5年生','小学6年生',
            '中学1年生','中学2年生','中学3年生',
            '高校1年生','高校2年生','高校3年生'
        ];

        // 指定がない場合は1年生
        $selectedGrade = $grade ?? $grades[0];

        // カリキュラム＋今月の配信スケジュールを取得
        $curriculums = Curriculum::with(['deliveryTimes' => function ($query) use ($startOfMonth, $endOfMonth) {
                $query->whereBetween('delivery_date', [$startOfMonth, $endOfMonth])
                      ->orderBy('delivery_date')
                      ->orderBy('start_time');
            }])
            ->where('grade', $selectedGrade)
            ->get();

        return view('user.timetable.index', compact('curriculums', 'date', 'grades', 'selectedGrade'));
    }
}
