<?php

namespace App\Console\Commands;

use App\Models\Log;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class GetPrice extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ib:getprice {sec} {bar}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $sec = $this->argument('sec');
        $bar = $this->argument('bar');

        $response = Http::withOptions([
            'verify' => false,
        ])->get("https://localhost:5000/v1/api/iserver/marketdata/snapshot?conids=495512566,265598");

        $log = new Log();
        $log->name = 'get_candle_'.$sec.'_B'.$bar;
        $log->json = $response->json();
        $log->save();

        // dd($response->json());

        return 0;
    }
}
