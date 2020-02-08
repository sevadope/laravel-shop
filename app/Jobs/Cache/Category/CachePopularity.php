<?php

namespace App\Jobs\Cache\Category;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Category;
use App\Cache\CacheManager;

class CachePopularity implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(CacheManager $cache)
    {
        $categories = Category::toBase()->get(['id', 'popularity']);
        $name = Category::POPULARITY_CACHE_NAME;
        #dd($categories);

        $popularity = [];
        foreach ($categories as $category) {
            $popularity[$category->id] = $category->popularity;
        }

        $cache->forget($name);
        $cache->putScoreValues($name, $popularity);

        info('Categories popularity list successfully cached');
    }
}
