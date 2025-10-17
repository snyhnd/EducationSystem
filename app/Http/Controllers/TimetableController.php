<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Curriculum;
use App\Models\DeliveryTime;
use Carbon\Carbon;

class TimetableController extends Controller
{
    public function index($year = null, $month = null, $grade = null)
    {
        // 年月（指定なしなら今月）
        $date = Carbon::createFromDate($year ?? now()->year, $month ?? now()->month, 1);

        $startOfMonth = $date->copy()->startOfMonth();
        $endOfMonth = $date->copy()->endOfMonth();

        // 学年リスト
        $grades = [
            '小学1年生','小学2年生','小学3年生',
            '小学4年生','小学5年生','小学6年生',
            '中学1年生','中学2年生','中学3年生',
            '高校1年生','高校2年生','高校3年生'
        ];

        // 学年が指定されていない場合は最初の学年を使用
        $selectedGrade = $grade ?? $grades[0];

        // 指定された学年に対応する授業＋配信スケジュールを取得
        $curriculums = Curriculum::with(['deliveryTimes' => function($query) use ($startOfMonth, $endOfMonth) {
                $query->whereBetween('delivery_date', [$startOfMonth, $endOfMonth])
                      ->orderBy('delivery_date')
                      ->orderBy('start_time');
            }])
            ->where('grade', $selectedGrade)
            ->get();

        return view('user.timetable.index', compact('curriculums', 'date', 'grades', 'selectedGrade'));
    }
}
