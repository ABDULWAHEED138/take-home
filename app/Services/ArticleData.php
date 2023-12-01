<?php

namespace App\Services;

use App\Traits\ArticleSource;
use Exception;

class ArticleData
{
    use ArticleSource;

    public function fetch()
    {
        try {
            $this->fetchArticle(self::$NEW_YORK_TIME);
            $this->fetchArticle(self::$THE_GUARDIAN);
            $this->fetchArticle(self::$NEWS_API);
        } catch (Exception $e) {
            report($e);
        }
    }
}
