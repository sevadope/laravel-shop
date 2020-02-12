<?php

namespace App\Jobs\Cache\Category;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Category;
use App\Cache\CacheManager;

class CacheScore implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $score_field = 'popularity';
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
        $value = (new Category)->getRouteKeyName();
        $categories = Category::get([$this->score_field, $value]);
        $score_name = Category::CACHED_SCORE_NAME;

        $list = [];
        foreach ($categories as $category) {
            $list[$category->{$value}] = $category->{$this->score_field};
        }

        $cache->forget($score_name);
        $cache->putScoreValues($score_name, $list);

        info('Categories list successfully cached');
    }
}
