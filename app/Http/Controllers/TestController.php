<?php

namespace App\Http\Controllers;

use App\GeneralSettings;
use App\InteractiveBrokers;
use App\Models\Order;
use App\Models\User;
use App\Notifications\Telegram;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TestController extends Controller
{
    //
    protected $bars = [
        '1min' => 60,
        '2min' => 120,
        '3min' => 180,
        '5min' => 300,
        '10min' => 600,
        '15min' => 900,
        '30min' => 1800,
        '1h' => 3600
    ];

    public function notify(){
    $users = User::all();
        foreach($users as $user)
            
                try{
                    dd($user->notify(new Telegram('test')));
                }catch (Exception $e) {
                    dd($e);

                }
    }

    public function candle(){
        // dd(time());
        $ib = new InteractiveBrokers;

        $candle = $ib->getCandle(495512566, '1min', true);
        // $candle = $ib->getCandle(265598, '1min');
        // $candle = $ib->getCandle(14237, '1d');

        dd($candle);



        // dd($ib->getCandle(499478683, '1min'));

        $bar = '15min';

        if(app(GeneralSettings::class)->test)
            if($this->bars[$bar]<900)
                $period='15min';
            else $period = $bar;

        $response = Http::withOptions([
            'verify' => false,
        ])->get("https://localhost:5000/v1/api/iserver/marketdata/history?conid=14237&period=$period&bar=$bar&outsideRth=true");
        
        dd($response->json());

        $orders = $response['orders'];
        
        if(empty($orders)){
            $response = Http::withOptions([
                'verify' => false,
            ])->get('https://localhost:5000/v1/api/iserver/account/orders');
            
            $orders = $response['orders'];
        }

        return $orders;
    }

    public function futures(){
        $response = Http::withOptions([
            'verify' => false,
        ])->get('https://localhost:5000/v1/api/trsrv/futures?symbols=GC');
        
        dd($response->json());
    }

    public function stocks(){
        $response = Http::withOptions([
            'verify' => false,
        ])->get('https://localhost:5000/v1/api/trsrv/stocks?symbols=BRIV');
        
        dd($response->json());
    }

    public function stop(){
        $orders = Order::where('status', 'NEW')->get();

        foreach($orders as $order){
            
        }
    }
}
