<?php

namespace App\Jobs\Cache\Category;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Category;
use App\Http\Resources\CategoryResource;
use App\Cache\CacheManager;

class CacheCategories implements ShouldQueue
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
        $categories = Category::with('descendants', 'ancestors')->get();
        $list_name = Category::getCacheListName();

        $json_categories = [];
        foreach ($categories as $category) {
            $json_categories[$category->getKey()] = json_encode(
                new CategoryResource($category)
            );
        }
        
        $cache->forget($list_name);
        $cache->putArrayValues($list_name, $json_categories);

        info('Categories successfully cached');
    }
}
