<?php

namespace App\Console\Commands\Cache;

use Illuminate\Console\Command;
use App\Jobs\Cache\CacheProducts;
use App\Jobs\Cache\Category\CacheCategories;
use App\Jobs\Cache\Category\CacheList;
use App\Jobs\Cache\Category\CacheScore;

class Refresh extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cache:refresh';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Refresh all cache';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        CacheCategories::dispatch();
        CacheList::dispatch();
        CacheScore::dispatch();
        CacheProducts::dispatch();
    }
}
