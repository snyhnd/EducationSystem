@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <h1 class="mb-4 fw-bold text-center">お知らせ一覧</h1>

            @foreach ($articles as $article)
                <div class="card mb-4 shadow-sm border-0">
                    <div class="card-body">
                        <h4 class="card-title mb-2">
                            <a href="{{ route('articles.show', $article->id) }}" 
                               class="text-decoration-none text-primary fw-bold">
                                {{ $article->title }}
                            </a>
                        </h4>

                        <p class="text-muted mb-2 small">
                            <i class="bi bi-calendar-event"></i>
                            {{ $article->posted_date->format('Y年n月j日') }}
                        </p>

                        <p class="card-text text-secondary">
                            {{ Str::limit($article->article_contents, 120) }}
                        </p>

                        <div class="text-end">
                            <a href="{{ route('articles.show', $article->id) }}" class="btn btn-outline-primary btn-sm">
                                詳細を見る
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach

            @if ($articles->isEmpty())
                <div class="alert alert-info text-center">
                    現在お知らせはありません。
                </div>
            @endif
        </div>
    </div>
</div>
@endsection