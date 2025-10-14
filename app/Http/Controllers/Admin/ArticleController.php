<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Http\Requests\UpdateArticleRequest;
use App\Http\Requests\StoreArticleRequest;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::orderBy('posted_date', 'desc')->get();
        return view('admin.articles.index', compact('articles'));
    }

    public function create()
{
    // 空のArticleインスタンスを渡す（フォームが空欄で表示される）
    $article = new Article();
    return view('admin.articles.edit', compact('article'));
}

    public function store(StoreArticleRequest $request)
{
    // バリデーション済みデータを取得
    $data = $request->validated();

    // 記事を登録
    Article::create([
        'title' => $data['title'],
        'article_contents' => $data['article_contents'],
        'posted_date' => $data['posted_date'],
    ]);

    return redirect()->route('admin.articles.index')->with('success', 'お知らせを登録しました');
}

    public function edit($id)
    {
        $article = Article::findOrFail($id);
        return view('admin.articles.edit', compact('article'));
    }

    public function update(UpdateArticleRequest $request, $id)
{
    $article = Article::findOrFail($id);
    $article->update($request->validated());

    return redirect()->route('admin.articles.index')
        ->with('success', 'お知らせを更新しました');
}
    public function destroy($id)
    {
        Article::findOrFail($id)->delete();
        return redirect()->route('admin.articles.index')->with('success', 'お知らせを削除しました');
    }
}
