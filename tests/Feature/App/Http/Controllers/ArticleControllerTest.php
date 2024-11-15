<?php

use App\Models\Article;

describe('index', function () {
    test('can list all articles', function () {
        $response = $this->get('/api/article');

        $content = $response->getContent();
        $json = json_decode($content);
        expect($response->getStatusCode())->toBe(200)
            ->and($content)->toBeJson()
            ->and($json?->meta?->total)->toEqual(Article::all()->count());
    });

    test('can get details from a article by slug', function () {
        $article = Article::factory()->create();

        $response = $this->get('/api/article/' . $article->getAttribute('slug'));

        $content = $response->getContent();
        $json = json_decode($content);
        $jsonArticle = $json?->data;

        expect($response->getStatusCode())->toBe(200)
            ->and($content)->toBeJson()
            ->and($jsonArticle->title)->toEqual($article->getAttribute('title'))
            ->and($jsonArticle->author)->toEqual($article->getAttribute('author'))
            ->and($jsonArticle->slug)->toEqual($article->getAttribute('slug'))
            ->and($jsonArticle->source)->toEqual($article->getAttribute('source_id'))
            ->and($jsonArticle->content)->toEqual($article->getAttribute('content'))
            ->and($jsonArticle->url)->toEqual($article->getAttribute('url'));
    });
});
