<?php

namespace App\Console\Commands\Cache;

use Illuminate\Console\Command;
use App\Jobs\Cache\CacheProducts as Job;

class CacheProducts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cache:products';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cache all products';

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
