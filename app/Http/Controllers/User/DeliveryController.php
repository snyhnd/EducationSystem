<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Curriculum;

class DeliveryController extends Controller
{
    public function show($id, Request $request)
{
    $curriculum = Curriculum::with(['grade'])->findOrFail($id);
    $grade = $request->query('grade', $curriculum->grade->name);
    $grade_id = $curriculum->grade->id;
    

    return view('user.layouts.delivery', compact('curriculum', 'grade','grade_id'));
}

    // public function show($id, Request $request)
    // {


    //     // $lesson = Curriculum::findOrFail($id);
    //     // $grade = $request->query('grade', '小学校1年生'); // ← クエリから取得（デフォルト付き）
    //     // $grade = Grade::find($lesson->grade_id)->name;


    //     return view('user.layouts.delivery', compact('lesson', 'grade'));
    // }
}
