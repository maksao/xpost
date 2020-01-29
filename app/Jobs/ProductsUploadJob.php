<?php

namespace App\Jobs;

use App\Imports\ProductsImport;
use Excel;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Storage;

class ProductsUploadJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 1;
    public $timeout = 0;
    public $user_id;
    public $filepath = 'products.xlsx';

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($user_id)
    {
        $this->user_id = $user_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Тут загрузка
        Excel::import(new ProductsImport(), $this->filepath, 'imports');

        Storage::disk('imports')->delete($this->filepath);
    }

    public function failed(Exception $exception)
    {
        Storage::disk('imports')->delete($this->filepath);
    }

}
