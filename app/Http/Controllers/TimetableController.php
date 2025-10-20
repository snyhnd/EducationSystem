<?php

namespace App\Http\Controllers;

use App\Models\Curriculum;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class TimetableController extends Controller
{
    public function index(?int $year = null, ?int $month = null)
    {
        $today = now();
        $base  = Carbon::create($year ?? $today->year, $month ?? $today->month, 1);

        $userId   = optional(auth()->user())->id;   // 未ログインでも動く
        $matrix   = Curriculum::buildMonthMatrix($userId, $base);
        $schedules= Curriculum::fetchForMonth($userId, $base);

        return view('user.timetable.index', [
            'current'   => $base,
            'matrix'    => $matrix,     // 週×日で描画したいとき
            'schedules' => $schedules,  // リスト表示したいとき
        ]);
    }
}
