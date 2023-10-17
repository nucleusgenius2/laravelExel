<?php

namespace App\Jobs;

use App\Http\Controllers\ExelController;
use App\Models\Rows;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Collection;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;


class ParserExel implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected array $data;

    /**
     * Create a new job instance.
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $id = time();
        $progress = 0;

        //запись в базу через чунки
        $dataBd = collect($this->data);

        $chunks = $dataBd->chunk(1000);

        foreach ($chunks as $chunk)
        {
            $result = Rows::insert($chunk->toArray());

            if( $result) {
                $progress = $progress + count($chunk);

                //сохранение прогресса в редис
                Redis::hmset('progress',[$id => $progress]);
            }
        }
    }
}
