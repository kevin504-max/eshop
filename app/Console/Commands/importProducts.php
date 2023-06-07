<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class importProducts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import-products';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        return app('App\Http\Controllers\Admin\ProductController')->getProductsFromWeb();
    }
}
