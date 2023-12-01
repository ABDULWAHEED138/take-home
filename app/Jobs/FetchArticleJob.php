<?php

namespace App\Jobs;

use App\Services\ArticleData;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Traits\ArticleSource;

class FetchArticleJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, ArticleSource;

    public ArticleData $articleData;

    /**
     * Create a new job instance.
     * @param ArticleData $articleData
     */
    public function __construct(ArticleData $articleData)
    {
        $this->articleData = $articleData;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {

        $this->articleData->fetch();
    }
}
