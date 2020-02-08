<?php

namespace App\Console\Commands\Cache\Category;

use Illuminate\Console\Command;
use App\Jobs\Cache\Category\CacheCategories as Job;

class CacheCategories extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cache:categories';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cache all categories';

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
        Job::dispatch();
    }
}
