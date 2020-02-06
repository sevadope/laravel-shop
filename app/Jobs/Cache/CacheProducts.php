<?php

namespace App\Jobs\Cache;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Product;
use App\Cache\CacheManager;
use App\Http\Resources\ProductResource;

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

        $res_products = [];
        foreach ($products as $product) {
            $res_products[$product->getKey()] = json_encode(
                new ProductResource($product)
            ); 
        }

        $cache->forget($name);
        $cache->putArrayValues($name, $res_products);

        info('Products successfully cached!');
    }
}
