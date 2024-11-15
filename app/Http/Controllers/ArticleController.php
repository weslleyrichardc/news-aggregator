<?php

namespace App\Http\Controllers;

use App\Http\Requests\ArticleIndexRequest;
use App\Http\Resources\ArticleCollection;
use App\Http\Resources\ArticleResource;
use App\Models\Article;

class ArticleController extends Controller
{
    public function index(ArticleIndexRequest $request): ArticleCollection
    {
        $keyword = $request->get('q');
        $author = $request->get('author');
        $source = $request->get('source');
        $from = $request->get('from');
        $to = $request->get('to');

        $articles = Article::query()
            ->when($keyword, function ($query) use ($keyword) {
                $query->orWhere('title', 'LIKE', '%' . $keyword . '%')
                    ->orWhere('slug', 'LIKE', '%' . $keyword . '%')
                    ->orWhere('content', 'LIKE', '%' . $keyword . '%');
            })
            ->when($author, function ($query) use ($author) {
                $query->orWhere('author', 'LIKE', '%' . $author . '%');
            })
            ->when($source, function ($query) use ($source) {
                $query->orWhere('source_id', 'LIKE', '%' . $source . '%');
            })
            ->when($from || $to, function ($query) use ($from, $to) {
                $query->orWhereBetween('published_at', [$from ?? now()->subMonths(12), $to ?? now()]);
            });

        return new ArticleCollection(
            $articles
                ->select('title', 'author', 'slug', 'source_id', 'content', 'url', 'published_at')
                ->orderBy('published_at', 'desc')
                ->paginate()
        );
    }

    public function show(Article $article): ArticleResource
    {
        return new ArticleResource($article);
    }
}
