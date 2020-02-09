<?php

namespace App\Console\Commands\Cache\Category;

use Illuminate\Console\Command;
use App\Jobs\Cache\Category\CacheList as Job;

class CacheList extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cache:categories:list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cache categories list';

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
