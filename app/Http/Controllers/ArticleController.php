<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    // お知らせ一覧
    public function index()
    {
        $articles = Article::orderBy('posted_date', 'desc')->get();
        return view('articles.index', compact('articles'));
    }

    // お知らせ詳細
    public function show($id)
    {
        $article = Article::findOrFail($id);
        return view('articles.show', compact('article'));
    }
}