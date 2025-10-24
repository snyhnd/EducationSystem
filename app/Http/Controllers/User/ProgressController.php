<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CurriculumClearCheck;
use App\Models\Curriculum;
use App\Models\CurriculumProgress;
use App\Models\ClassesClearCheck;

class ProgressController extends Controller
{
    public function store(Request $request, $id)
    {
        $userId = auth()->id();
        $gradeId = $request->input('grade_id');

        // grade_idが渡されていない場合はエラーを返す
        if (is_null($gradeId)) {
            return back()->withErrors(['grade_id' => '学年IDが渡されていません。']);
        }

        // 受講記録の取得または新規作成
        $record = CurriculumClearCheck::firstOrNew([
            'users_id' => $userId,
            'grade_id' => $gradeId,
        ]);

        // クリアフラグを立てる
        $record->clear_flg = 1;

        // 保存
        $record->save();

        // 学年の進捗判定と更新
        $this->updateGradeClearStatus($gradeId, $userId);

        // 成功メッセージとともにリダイレクト
        return redirect()->back()->with('status', '受講済みにしました');
    }

    /**
     * 学年のすべてのカリキュラムが受講済みなら、classes_clear_checksのclear_flgを1に更新
     */
    private function updateGradeClearStatus($gradeId, $userId)
{
    // 学年に属するカリキュラム数を取得
    $totalCount = Curriculum::where('grade_id', $gradeId)->count();

    // ユーザーがその学年で受講済みにした数を取得
    $clearedCount = CurriculumClearCheck::where('users_id', $userId)
        ->where('grade_id', $gradeId)
        ->where('clear_flg', 1)
        ->count();

    if ($totalCount > 0 && $clearedCount === $totalCount) {
        // 全てクリア済み → 学年進捗フラグを更新
        ClassesClearCheck::updateOrCreate(
            ['users_id' => $userId, 'grade_id' => $gradeId],
            ['clear_flg' => 1]
        );
    }
}

}
