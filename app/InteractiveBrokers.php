<?php

namespace App;

use App\Models\Log;
use App\Models\User;
use App\Notifications\Telegram;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class InteractiveBrokers
{
    protected $bars = [
        '1min' => 60,
        '2min' => 120,
        '3min' => 180,
        '5min' => 300,
        '10min' => 600,
        '15min' => 900,
        '30min' => 1800,
        '1h' => 3600,
        '2h' => 7200,
        '4h' => 14400,
        '1d' => 86400
    ];

    public static function notify($msg){
        $users = User::all();
        foreach($users as $user)
            try{
                $user->notify(new Telegram($msg));
            }catch (Exception $e) {

            }
    }
    //
    function getHttpCode($http_response_header)
    {
        if(is_array($http_response_header))
        {
            $parts=explode(' ',$http_response_header[0]);
            // dd($parts);
            if(count($parts)>1) //HTTP/1.0 <code> <text>
                return intval($parts[1]); //Get code
        }
        return 0;
    }
    
    // public function status(){

    //     $contextOptions = array(
    //         'ssl' => array(
    //             'verify_peer'       => true,
    //             'allow_self_signed' => true
    //         ),
    //         "http" => array(
    //             "header" => "User-Agent: Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/50.0.2661.102 Safari/537.36"
    //         )
    //     );
    //     $sslContext = stream_context_create($contextOptions);
    //     $json = @file_get_contents("https://localhost:5000/v1/api/iserver/auth/status", false, $sslContext);
        
    //     $code=$this->getHttpCode($http_response_header);

    //     if($code==200){
    //         $obj = json_decode($json);
    //         return $obj;
    //     }     

    //     return $code;
    // }

    public function status(){
        $status = false;
        try{
            $response = Http::withOptions([
                'verify' => false,
            ])->get('https://localhost:5000/v1/api/iserver/auth/status');
            if($response->successful()) $status = $response->json();
            if($response->failed()){
                $log = new Log;
                $log->name = 'status failed';
                $log->json = ['failed' => $response->json()];
                $log->save();
            }
        }catch(Exception $e){
            $log = new Log;
            $log->name = 'status error';
            $log->json = ['http_error' => $e->getMessage()];
            $log->save();

            $status = false;
        }

        return $status;
    }

    public function gatewayCheck(){
        
        $status = $this->status();
        
        if($status)
            if($status['authenticated'] && !$status['competing'] && $status['connected']) return true;
            // else $this->notify('Logout from other instances and re-login on clientportal');

        return false;

    }
    
    public function accounts(){
        // $contextOptions = array(
        //     'ssl' => array(
        //         'verify_peer'       => true,
        //         'allow_self_signed' => true
        //     ),
        //     "http" => array(
        //         "header" => "User-Agent: Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/50.0.2661.102 Safari/537.36"
        //     )
        // );
        // $sslContext = stream_context_create($contextOptions);
        // $json = file_get_contents("https://localhost:5000/v1/api/portfolio/accounts", false, $sslContext);
        // $obj = json_decode($json);
        // dd($obj);
        $response = Http::withOptions([ 
            'verify' => false,
        ])->get('https://localhost:5000/v1/api/iserver/accounts');
        return $response->json();
    }

    public function accountIds(){
        $accounts = $this->accounts();
        if($accounts)
            if(array_key_exists('accounts', $accounts)){
                $ids =  $accounts['accounts'];
                if(is_int($all = array_search('All', $ids)))
                    unset($ids[$all]);
                return $ids;
            }
                
            else return false;
        else return false;
    }

    public function selectedAccount($all = false){
        $accounts = $this->accounts();
        if($accounts){
            if(array_key_exists('accounts', $accounts)){
                $ids = $accounts['accounts'];
                if(!$all)
                    if(is_int($all = array_search('All', $ids)))
                        unset($ids[$all]);
            }
            else return false;

            if(array_key_exists('selectedAccount', $accounts))
                $selected = $accounts['selectedAccount'];
            else return false;

            $accounts = array_fill_keys($ids, false);

            foreach($accounts as $account => $value)
                if($account==$selected)$accounts[$account]=true;

            return $accounts;
            
        }
        else return false;
    }

    public function switchAccount($acctId){
        $response = Http::withOptions([
            'verify' => false,
        ])->post('https://localhost:5000/v1/api/iserver/account', ['acctId' => $acctId]);
        return $response->json();
    }

    public function getPositions($acctId){
        // $ib = new InteractiveBrokers;
        // if($this->gatewayCheck()){
            $response = Http::withOptions([
                'verify' => false,
            ])->get('https://localhost:5000/v1/api/portfolio/'.$acctId.'/positions');
            // dd($response);
            return $response->json();
        // }
        // return false;
    }

    public function order($acctId, int $conid, $orderType, float $quantity, $side, $tif, bool $outside_rth = false, float $price=null, float $auxPrice=null){
        $optional = [];
        if($price) $optional['price'] = $price;
        if($auxPrice) $optional['auxPrice'] = $auxPrice;
        // dd();
        $order = array_merge([
            'acctId' => $acctId,
            'conid' => $conid,
            'orderType' => $orderType,
            'quantity' => $quantity,
            'side' => $side,
            'outsideRTH' => $outside_rth,
            'tif' => $tif
        ], $optional);
        // dd($order);

        $log = new Log;
        $log->name = 'order_request conid:'. $conid;
        $log->json = $order;
        $log->save();

        $response = Http::withOptions([
            'verify' => false,
        ])->post('https://localhost:5000/v1/api/iserver/account/'.$acctId.'/orders', ["orders" => [ $order]]);

        // dd($response->json());
        
        $log = new Log;
        $log->name = 'order_response conid:'. $conid;
        $log->json = $response->json();
        $log->save();
        
        $reply = array_key_exists('id', $response->json()[0]);
        // print_r($response->json());
    
        while($reply)
        {
            $response = Http::withOptions([
                'verify' => false,
                ])->post('https://localhost:5000/v1/api/iserver/reply/'.$response->json()[0]['id'], [
                    'confirmed' => true
                ]);

            $log = new Log;
            $log->name = 'order_reply';
            $log->json = $response->json();
            $log->save();
            try{
                $reply = array_key_exists('id', $response->json()[0]);
            }catch(Exception $e){
                $log = new Log;
                    $log->name = 'error order';
                    $log->json = ['response' => $response->json(), 'price' => $e];
                    $log->save();

                    return false;
            }
        }       
        return $response->json();
    }

    public function modifyOrder($acctId, int $orderId, int $conid, $orderType, float $quantity, $side, $tif, bool $outside_rth = false, float $price = 0, $auxPrice = 0){

        $order = [
            'acctId' => $acctId,
            'conid' => $conid,
            // // 'secType' => "STK",
            'orderType' => $orderType,
            'quantity' => $quantity,
            // // 'listingExchange' => 'SMART',
            'side' => $side,
            // // 'ticker' => 'AAPL',
            'price' => $price,
            'auxPrice' => $auxPrice,
            'outsideRTH' => $outside_rth,
            'tif' => $tif,
        ];

        $log = new Log;
        $log->name = 'modyfy_order_request conid:'. $conid;
        $log->json = $order;
        $log->save();

        $response = Http::withOptions([
            'verify' => false,
            ])->post('https://localhost:5000/v1/api/iserver/account/'.$acctId.'/order/'.$orderId, $order);

        $log = new Log;
        $log->name = 'modify_order_response';
        $log->json = ['response' => $response->json()];
        $log->save();
        // if($price == 9.95)dd($response->json());
        // dd($response->json(), $acctId, $orderId, $conid);
        if(array_key_exists('error', $response->json()[0]))return false;
        if(array_key_exists('id', $response->json()[0])){
            // dd($response->json());
            $reply = array_key_exists('id', $response->json()[0]);
            // print_r($response->json());
        
            while($reply)
            {
                $response = Http::withOptions([
                    'verify' => false,
                    ])->post('https://localhost:5000/v1/api/iserver/reply/'.$response->json()[0]['id'], [
                        'confirmed' => true
                    ]);
    // dd($response->json());
                $log = new Log;
                $log->name = 'order_reply';
                $log->json = $response->json();
                $log->save();
    
                try{
                    $reply = array_key_exists('id',  $response->json()['response'][0]);
                }catch (Exception $e){
                    $log = new Log;
                    $log->name = 'error modify_order';
                    $log->json = ['response' => $response->json(), 'price' => $e];
                    $log->save();

                    return false;
                }
                
            }
        }
        // dd($response->json());
        if(array_key_exists('order_id', $response->json()[0]))
            return $response->json();
        else return false;
    }

    public function getSTKContracts($symbol){
        
        $response = Http::withOptions([
            'verify' => false,
        ])->get('https://localhost:5000/v1/api/trsrv/stocks?symbols=' . $symbol);
        // dd($response->json());
        return $response->json()[$symbol];

    }

    public function getFUTContracts($symbol){
        
        $response = Http::withOptions([
            'verify' => false,
        ])->get('https://localhost:5000/v1/api/trsrv/futures?symbols=' . $symbol);
        // dd($response->json());
        return $response->json()[$symbol];

    }

    public function unsubscribe($conid){
        
        $response = Http::withOptions([
            'verify' => false,
        ])->get('https://localhost:5000/v1/api/iserver/marketdata/'.$conid.'/unsubscribe');
        // dd($response->json());
        return true;

    }

    public function mktprice($conid){

        $response = Http::withOptions([
            'verify' => false,
        ])->get('https://localhost:5000/v1/api/iserver/marketdata/snapshot?conids='.$conid.'&fields=31');
        
        $contracts = $response->json();
        // dd($contracts);
        $price = false;
        if($contracts)
            foreach($contracts as $contract)
                if($contract['conidEx'] == $conid){
                    if(array_key_exists(31, $contract)) $price = $contract[31];
                }
        return (float)$price;

        
    }

    public function orders(){
        $response = Http::withOptions([
            'verify' => false,
        ])->get('https://localhost:5000/v1/api/iserver/account/orders');
        
        $orders = $response['orders'];
        
        if(empty($orders)){
            $response = Http::withOptions([
                'verify' => false,
            ])->get('https://localhost:5000/v1/api/iserver/account/orders');
            
            $orders = $response['orders'];
        }

        return $orders;
    }

    public function cancelOrder($acctId, $orderId){
        // dd('/order//');
        $response = Http::withOptions([
            'verify' => false,
            ])->delete('https://localhost:5000/v1/api/iserver/account/'.$acctId.'/order/'.$orderId);

        $log = new Log;
        $log->name = 'cancel_order ' . $orderId;
        $log->json = $response->json();
        $log->save();

        return $response->json();
    }

    public function getSymbol($conid){
        $response = Http::withOptions([
            'verify' => false,
        ])->get('https://localhost:5000/v1/api/iserver/contract/'.$conid.'/info');
        
        return $response['symbol'];
    }

    public function outside_rth($conid, $type){

        $response = Http::withOptions([
                'verify' => false,
            ])->get('https://localhost:5000/v1/api/iserver/contract/' . $conid . '/info-and-rules');

        $rules = $response->json('rules');

        dd($rules);

        $types = [
            'LMT' => "limit",
            'STOP_LIMIT' => "stop_limit"
        ];
        $outside_rth = false;
    
        if(array_key_exists($type, $types))
            
            if(array_key_exists('orderTypesOutside', $rules)){
                if(is_int(array_search($types[$type], $rules['orderTypesOutside']))) $outside_rth = true;
            };

        dd($outside_rth);

        return $outside_rth;
    }

    public function orderStatus($orderId){
        $response = Http::withOptions([
            'verify' => false,
        ])->get('https://localhost:5000/v1/api/iserver/account/order/status/'. $orderId);

        return $response->json();
    }

    public function runningOrders(){
        $response = Http::withOptions([
            'verify' => false,
        ])->get('https://localhost:5000/v1/api/iserver/account/orders');

        return $response->json('orders');
    }
    
    public function accountSummary($acctId){
        $response = Http::withOptions([
            'verify' => false,
        ])->get('https://localhost:5000/v1/api/portfolio/'. $acctId .'/summary');

        return $response->json();
    }

    public function getCandle($conid, $bar, $outside_rth = false){
        // dd(1);

        $period = $bar;

        
        // if(app(GeneralSettings::class)->test){
        //     if($this->bars[$bar]<=900)
        //         $period='16min';
        //     $time -= 900;
        // }

        $retry = true;
        $tries = 0;

        if($outside_rth)$outside_rth='true';
        else $outside_rth='false';

        // dd("outsideRth=$outside_rth");

        while($retry){
            $tries++;
            sleep(2);
            $time = time();


            $response = Http::withOptions([
                'verify' => false,
            // ])->get("https://localhost:5000/v1/api/iserver/marketdata/history?conid=$conid&period=2d&bar=$bar&outsideRth=true");
            ])->get("https://localhost:5000/v1/api/iserver/marketdata/history?conid=$conid&period=$period&bar=$bar&outsideRth=$outside_rth");

            // dd($response->json());

            $log = new Log;
            $log->name = 'candle_B'.$bar.'_P'.$period.'#'.$conid;
            $log->json = ['response' => $response->json()];
            $log->save();

            foreach($candles = $response->json()['data'] as $key => $candle){
                // $candles[$key]['datetime'] = date('d-m-Y H:i:s', $candle['t']/1000);
                if((($candle['t']/1000) < $time- $this->bars[$bar]) && (($candle['t']/1000) > ($time - 2 * $this->bars[$bar])))
                    $log = new Log;
                    $log->name = 'good_candle_B'.$bar.'_P'.$period.'#'.$conid;
                    $log->json = ['candle' => $candle];
                    $log->save();
                    // return $candle;
            }

            dd($candles, $response->json());

            

            $candles = $response->json()['data'];

            // dd(end($candles));

            if($candle = end($candles)){
                if((($candle['t']/1000) < $time) && (($candle['t']/1000) > ($time - $this->bars[$bar])))
                    $log = new Log;
                    $log->name = 'good_candle_B'.$bar.'_P'.$period.'#'.$conid;
                    $log->json = ['candle' => $candle];
                    $log->save();
                    return $candle;
            }
            if($tries > 20) $retry = false;
            if($retry) sleep(2);
        }

// dd('pl');

        return false;
    }

    public function getClose($conid, $outside_rth){
        $period = '1min';
        $bar = '1min';
        $url = "https://localhost:5000/v1/api/iserver/marketdata/history?conid=$conid&period=$period&bar=$bar&outsideRth=$outside_rth";
        if($outside_rth) $url .= '&outsideRth=true';

        $response = Http::withOptions([
            'verify' => false,
        // ])->get("https://localhost:5000/v1/api/iserver/marketdata/history?conid=$conid&period=2d&bar=$bar&outsideRth=true");
        ])->get($url);

        $time = time();

        if(array_key_exists('data', $json = $response->json()))
            foreach($candles = $json['data'] as $key => $candle){
                // $candles[$key]['datetime'] = date('d-m-Y H:i:s', $candle['t']/1000);
                if((($candle['t']/1000) < $time - 60) && (($candle['t']/1000) > ($time - 120)))
                    // $log = new Log;
                    // $log->name = 'good_candle_'.$sec.'_B'.$bar.'#'.$conid.'|'.$symbol;
                    // $log->json = ['close' => $candle['c'], 'datetime' => date('d-m-Y H:i:s', $candle['t']/1000)];
                    // $log->save();
                    return $candle['c'];
                    // return $candle;
            }

        return false;
    }
    

}