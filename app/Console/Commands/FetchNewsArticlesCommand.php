<?php

namespace App\Console\Commands;

use App\Models\Article;
use App\Models\Source;
use App\Services\NewsApiService\NewsApiService;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class FetchNewsArticlesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'news:fetch-articles';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch latest articles';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $newsApiService = new NewsApiService();

        $response = $newsApiService->news([
            'q' => 'ai',
//            'from' => '2024-11-01',
//            'to' => '2024-11-15',
//            'sortBy' => 'publishedAt',
        ])->json();
        $articles = collect($response['articles']);

        $this->info('Fetching ' . $articles->count() . ' latest articles' . PHP_EOL);

        $articles->each(function ($article) {
            $this->info('Fetching article: ' . $article['title']);

            $source = Source::query()->updateOrCreate([
                'name' => $article['source']['name'],
                'slug' => Str::of($article['source']['name'])->slug('-'),
            ]);

            $slug = Str::of($article['title'])->slug('-');
            if (Article::query()->where('slug', $slug)->exists()) {
                return;
            }

            Article::query()
                ->updateOrCreate([
                    'title' => $article['title'],
                    'slug' => $slug,
                ], [
                    'author' => $article['author'],
                    'url' => $article['url'],
                    'source_id' => $source->getAttribute('id'),
                    'content' => $article['content'],
                    'published_at' => $article['publishedAt'],
                ]);
        });
    }
}
