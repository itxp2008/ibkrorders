<?php

namespace App\Console\Commands;

use App\GeneralSettings;
use App\InteractiveBrokers;
use App\Models\Log;
use App\Models\Order;
use App\Models\User;
use App\Notifications\Telegram;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class GetCandle extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ib:getcandle {sec} {bar}';

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

        

        return Command::SUCCESS;


        $orders = Order::where('bar', $bar)->where('status', 'NEW')->get();

        // dd($orders);

        if($orders){
            $ib = new InteractiveBrokers;

            foreach ($orders as $order){
                $candle = $ib->getCandle($order->conid, $bar);

                if($candle){
                    $execute = false;

                    $close = $candle['c'];

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

                        if($order->type == 'STOP') $type = 'MKT';
                        if($order->type == 'STOP-LIMIT') $type = 'LMT';
                        // dd($type);

                        $ib->order(app(GeneralSettings::class)->account,
                            $order->conid, 
                            $type,
                            $order->qty,
                            $order->side,
                            'GTC',
                            false,
                            ($type=='LMT')?$order->limit:null);
                        
                        $order->status = 'SUMITTED';

                        $order->update();



                    }
                }
            }
        }
       

        


        // $conid = 265598;

        // $period = $bar = $this->argument('bar');

        // if(app(GeneralSettings::class)->test)
        //     if($this->bars[$bar]<=900)
        //         $period='16min';

        // $response = Http::withOptions([
        //     'verify' => false,
        // ])->get("https://localhost:5000/v1/api/iserver/marketdata/history?conid=$conid&period=$period&bar=$bar");

        // $log = new Log;
        // $log->name = 'get_candle_B'.$bar.'_P'.$period.'#'.$conid;
        // $log->json = ['failed' => $response->json()];
        // $log->save();
        
        return Command::SUCCESS;
    }

    private function notify($msg){
        $users = User::whereNotNull('telegram')->get();
        foreach($users as $user)
            try{
                $user->notify(new Telegram($msg));
            }catch (Exception $e) {

            }
    }
}
