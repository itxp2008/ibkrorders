<?php

namespace App\Console\Commands;

use App\GeneralSettings;
use App\InteractiveBrokers;
use App\Models\Log;
use App\Models\Order;
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

        $orders = Order::where('bar', $bar)->where('sec', $sec)->where('status', 'NEW')->get();

        if($orders){

            $ib = new InteractiveBrokers;

            foreach($orders as $order){
                $close = $ib->getClose($order->conid, ($order->sec == 'FUT'));

                // dd($order);

                if($close){
                    
                    $execute = false;

                    if($order->side == 'BUY')
                        if($close > $order->stop)
                            $execute = true;
                        elseif($order->trailing){
                            if(($stop = $close + $order->stop_offset) < $order->stop){
                                $order->stop = $stop;
                                $order->update();
                            } 
                            if($order->type == 'STOP-LIMIT')
                                if(($limit = $close + $order->limit_offset) < $order->limit){
                                    $order->limit = $limit;
                                    $order->update();
                                }
                        }
                            
                    if($order->side == 'SELL')
                        if($close < $order->stop)
                            $execute = true;
                        elseif($order->trailing){
                            if(($stop = $close - $order->stop_offset) > $order->stop){
                                $order->stop = $stop;
                                $order->update();
                            }
                            if($order->type == 'STOP-LIMIT')
                                if(($limit = $close - $order->limit_offset) > $order->limit){
                                    $order->limit = $limit;
                                    $order->update();
                                }
                        }

                    if($execute){

                        if($order->type == 'STOP') $type = 'STP';
                        if($order->type == 'STOP-LIMIT') $type = 'STOP_LIMIT';
                        // dd($type);

                        $ib->order(app(GeneralSettings::class)->account,
                            $order->conid, 
                            $type,
                            $order->qty,
                            $order->side,
                            'GTC',
                            ($order->sec == 'FUT'),
                            ($type=='STOP_LIMIT')?$order->limit:null);
                            // ($type=='STOP_LIMIT')?$order->limit:null);
                        
                        $order->status = 'SUMITTED';

                        $order->update();



                    }
                }

                Log::create([
                    'name' => 'good_candle_'.$sec.'_B'.$bar.'#'.$order->conid.'|'.$order->symbol,
                    'json' => ['close' => $close]
                ]);
            }

        }
        // $conids = [
        //     'GC SEP22' => 570499471,
        //     'ES SEP22 (50)' => 495512566,
        //     'CL OCT22 (1000)' => 256019330,
        //     'SI SEP22 (5000)' => 452392398,
        //     'MES SEP22 (5)' => 497954518,
        //     'NQ SEP22 (20)' => 497954599
        // ];

        // $period = '1min';
        // // $bar = '1min';
        // $outside_rth = 'true';

        // foreach($conids as $symbol => $conid){
        //     $response = Http::withOptions([
        //         'verify' => false,
        //     // ])->get("https://localhost:5000/v1/api/iserver/marketdata/history?conid=$conid&period=2d&bar=$bar&outsideRth=true");
        //     ])->get("https://localhost:5000/v1/api/iserver/marketdata/history?conid=$conid&period=$period&bar=1min&outsideRth=$outside_rth");

        //     $time = time();

        //     if(array_key_exists('data', $json = $response->json()))
        //         foreach($candles = $json['data'] as $key => $candle){
        //             // $candles[$key]['datetime'] = date('d-m-Y H:i:s', $candle['t']/1000);
        //             if((($candle['t']/1000) < $time - 60) && (($candle['t']/1000) > ($time - 120)))
        //                 // $log = new Log;
        //                 // $log->name = 'good_candle_'.$sec.'_B'.$bar.'#'.$conid.'|'.$symbol;
        //                 // $log->json = ['close' => $candle['c'], 'datetime' => date('d-m-Y H:i:s', $candle['t']/1000)];
        //                 // $log->save();
        //                 Log::create([
        //                     'name' => 'good_candle_'.$sec.'_B'.$bar.'#'.$conid.'|'.$symbol,
        //                     'json' => ['close' => $candle['c'], 'datetime' => date('d-m-Y H:i:s', $candle['t']/1000)]
        //                 ]);
        //                 // return $candle;
        //         }
        // }

        // // $response = Http::withOptions([
        // //     'verify' => false,
        // // ])->get("https://localhost:5000/v1/api/iserver/marketdata/snapshot?conids=495512566,265598");

        // Log::create([
        //     'name' => 'executed '.$sec,
        //     'json' => ['bar' => $bar]
        // ]);
        // // $log->name = 'executed '.$sec;
        // // $log->json = ['bar' => $bar];
        // // $log->save();

        // // dd($response->json());

        return 0;
    }
}
