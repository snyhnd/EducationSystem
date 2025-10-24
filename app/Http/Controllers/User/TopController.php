<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Article;

class TopController extends Controller
{
    public function index()
    {
        $banners = Banner::all();
        $articles = Article::orderBy('posted_date', 'desc')->take(5)->get();

        return view('welcome', compact('banners', 'articles'));
    }
}

