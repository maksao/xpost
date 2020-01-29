<?php

namespace App\Jobs;

use App\Imports\PricesImport;
use App\Pricelist;
use Carbon\Carbon;
use Excel;
use File;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Exception;
use Storage;

class PricelistUploadJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 1;
    public $timeout = 0;
    public $data;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //throw new Exception('Задание отменено: указанный id прайслиста ('.$this->data['pricelist_id'].') не найден', 101);

        $pricelist = Pricelist::findOrFail($this->data['pricelist_id']);

        $path = 'pricelist' . $pricelist->id . '.xlsx';

        // Тут загрузка
        Excel::import(new PricesImport($pricelist->id), $path, 'imports');

        $pricelist->update([
            'status' => 0,
            'last_updated_at'=>Carbon::now()
        ]);
        $pricelist->setLog('Цены обновлены', $this->data['user_id']);

        Storage::disk('imports')->delete($path);
    }

    public function failed(Exception $exception)
    {
        Pricelist::findOrFail($this->data['pricelist_id'])->update(['status'=>2]);
        //info(__CLASS__ . 'Проверка ошибок - id: '.$this->data['pricelist_id']);
    }
}
