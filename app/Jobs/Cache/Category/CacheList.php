<?php

namespace App\Jobs\Cache\Category;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Category;
use App\Cache\CacheManager;

class CacheList implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $cache_key = 'popularity';

    private $cache_fields = [
        'id', 'name', 'slug', 'image',
    ];

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
        $categories = Category::get();
        $name = Category::CACHED_LIST_NAME;

        $list = [];

        foreach ($categories as $category) {
            // set json as key and cache key as value
            $list[serialize(
                array_intersect_key(
                    $category->getAttributes(),
                    array_flip($this->cache_fields)
            ))] = $category->{$this->cache_key};
        }

        $cache->forget($name);
        $cache->putScoreValues($name, $list);

        info('Categories list successfully cached');
    }
}
