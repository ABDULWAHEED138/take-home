<?php

namespace App\Traits;

use App\Models\Article;
use App\Models\Category;
use App\Models\Source;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

trait ArticleSource
{
    static $NEW_YORK_TIME = 'New York Times';
    static $THE_GUARDIAN = 'The Guardian';
    static $NEWS_API = 'News API';
    static $MAX_LIMIT = 10;

    public function fetchArticle(string $provider)
    {
        switch ($provider) {
            case self::$NEW_YORK_TIME:

                $response = Http::get(config('services.article.new_york_time_api_endpoint'), [
                    'api-key' => config('services.article.new_york_time_api_key')
                ]);


                $response = collect($response->json());

                if ($response->has('status') && $response['status'] != 'OK') {
                    break;
                }

                if (!$response->has('response')) {
                    break;
                }


                $articles = $response['response']['docs'];
                foreach ($articles as $article) {

                    $source = Source::query()->firstOrCreate(['name' => $article['source'] ?? '']);
                    $category = Category::query()->firstOrCreate(['name' => $article['news_desk'] ?? '']);

                    if (Article::query()->where('title', $article['headline']['main'])->exists()) {
                        continue;
                    }

                    $createArray = [
                        'source_id'   => $source->getAttributeValue('id'),
                        'category_id' => $category->getAttributeValue('id'),
                        'author'      => $article['byline']['original'],
                        'title'       => $article['headline']['main'],
                        'description' => $article['abstract'],
                        'url'         => $article['web_url'],
                        'content'     => $article['lead_paragraph'],
                        'publish_at'  => $article['pub_date'],
                    ];

                    if (isset($article['multimedia'][0]['url'])) {
                        array_merge($createArray, [
                            'image_url' => 'https://www.nytimes.com/' . $article['multimedia'][0]['url'],
                        ]);
                    }

                    (new Article())->fill($createArray)->save();

                }

                break;

            case self::$THE_GUARDIAN:

                $response = Http::get(config('services.article.the_guardian_api_endpoint'), [
                    'api-key' => config('services.article.the_guardian_api_key')
                ]);


                $response = collect($response->json());

                if (!$response->has('response')) {
                    break;
                }

                if (!isset($response['response']['status']) OR $response['response']['status'] != 'ok') {
                    break;
                }


                $articles = $response['response']['results'];
                foreach ($articles as $article) {

                    $source = Source::query()->firstOrCreate(['name' => self::$THE_GUARDIAN]);
                    $category = Category::query()->firstOrCreate(['name' => $article['sectionName']]);

                    if (Article::query()->where('title', $article['webTitle'])->exists()) {
                        continue;
                    }

                    $createArray = [
                        'source_id'   => $source->getAttributeValue('id'),
                        'category_id' => $category->getAttributeValue('id'),
                        //'author'      => $article['byline']['original'],
                        'title'       => $article['webTitle'],
                        //'description' => $article['abstract'],
                        'url'         => $article['webUrl'],
                        //'image_url'   => 'https://www.nytimes.com/' . $article['multimedia'][0]['url'],
                        //'content'     => $article['lead_paragraph'],
                        'publish_at'  => $article['webPublicationDate'],
                    ];

                    (new Article())->fill($createArray)->save();

                }


                break;

            case self::$NEWS_API:

                $response = Http::get(config('services.article.news_api_endpoint'), [
                    'apiKey'   => config('services.article.news_api_key'),
                    'language' => 'en'
                ]);


                $response = collect($response->json());

                if (!isset($response['status']) OR $response['status'] != 'ok') {
                    break;
                }


                $articles = $response['articles'];
                foreach ($articles as $article) {

                    $source = Source::query()->firstOrCreate(['name' => $article['source']['name']]);

                    if (Article::query()->where('title', $article['title'])->exists()) {
                        continue;
                    }

                    $createArray = [
                        'source_id'   => $source->getAttributeValue('id'),
                        'author'      => $article['author'],
                        'title'       => $article['title'],
                        'description' => $article['description'],
                        'url'         => $article['url'],
                        'image_url'   => $article['urlToImage'],
                        'content'     => $article['content'],
                        'publish_at'  => $article['publishedAt'],
                    ];

                    (new Article())->fill($createArray)->save();

                }


                break;

            default:
                break;
        }
    }

    private function handleResponse(Response $response): array
    {
        if ($response->successful()) {
            return $response->json();
        }
        return [];
    }
}
