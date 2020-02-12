<?php

namespace App\Jobs\Cache\Category;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Category;
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
        $key = $categories->first()->getRouteKeyName();

        $keys = [];
        $arrs = [];
        foreach ($categories as $category) {
            $arrs[$keys[] = 'category:'.$category->{$key}] = array_merge(
                $category->getAttributes(),
                ['relations' => serialize(
                    $this->relationsToKeysArray($category->getRelations())
                )]
           );
        }
        
        foreach ($arrs as $name => $fields) {
            $cache->forget($name);
            $cache->putArrayValues($name, $fields);
        }

        info('Categories successfully cached');
    }

    public function relationsToKeysArray($relations)
    {
        return array_map(  
            function ($rel) {
                return $rel->isEmpty() ? []
                    : $rel->pluck($rel->first()->getRouteKeyName())->toArray();
            },  
            $relations
        );
    }
}
