<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\Telegram;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TestController extends Controller
{
    //
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
        $response = Http::withOptions([
            'verify' => false,
        ])->get('https://localhost:5000/v1/api/iserver/marketdata/history?conid=260862601&period=3h&bar=3h');
        
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
        ])->get('https://localhost:5000/v1/api/trsrv/stocks?symbols=AAPL');
        
        dd($response->json());
    }
}
