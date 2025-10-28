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

        return view('user.layouts.delivery', compact('curriculum', 'grade', 'grade_id'));
    }
}
