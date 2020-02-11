<?php

namespace App\Jobs\Cache;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Product;
use App\Cache\CacheManager;

class CacheProducts implements ShouldQueue
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
        $products = Product::with('specifications', 'options')->get();
        $name = Product::getCacheListName();

        $strings = [];
        foreach ($products as $product) {
            $strings[$product->getKey()] = serialize($product); 
        }

        $cache->forget($name);
        $cache->putArrayValues($name, $strings);

        info('Products successfully cached!');
    }
}
