<?php

namespace App\Http\Controllers;

use App\GeneralSettings;
use App\Http\Requests\GetContractsRequest;
use App\Http\Requests\PostOrderRequest;
use App\InteractiveBrokers;
use App\Models\Log;
use App\Rules\IntegerIf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Psy\VersionUpdater\IntervalChecker;

class IBController extends Controller
{
    //
    public function newOrder(){

        // dd('pl');
        $ib = new InteractiveBrokers;
        $accounts = $ib->selectedAccount();

        $orderType = [
            'MKT' => 'MARKET',
            'LMT' => 'LIMIT',
            'STP' => 'STOP',
            'STOP_LIMIT' => 'STOP LIMIT'
        ];

        $side = [
            'BUY' => 'BUY',
            'SELL' => 'SELL'
        ];

        $tif = [
            'GTC' => 'Good-Till-Cancel',
            'DAY' => 'DAY'
        ];

        return view('ib.order', compact('accounts', 'orderType', 'side', 'tif'));
    }

    public function postOrder(PostOrderRequest $request){

        // dd($request->all());
        // $request->validate(['quantity' => [new IntegerIf('outside_rth')]]);

        $ib = new InteractiveBrokers;

        // if($request->outside_rth)
        //     $outside_rth = $ib->outside_rth($request->conid, $request->orderType);
        // else $outside_rth = false;
        $outside_rth = true;

        $ib->order($request->acctId, $request->conid, $request->orderType, $request->quantity, $request->side, $request->tif, $outside_rth, $request->price, $request->auxPrice);

        // $log = new Log;
        // $log->name = 'IB direct order_request conid:'. $request->conid;
        // $log->json = $response;
        // $log->save();

        return redirect()->route('ib.orders');

    }

    public function orders(){

        $ib = new InteractiveBrokers;
        
        // $orders = $ib->orders();
        // $orders = ;
        
        $orders = collect($ib->orders())->sortByDesc('lastExecutionTime_r')->map(function ($item, $key) {
            $item['time'] = date("Y-m-d H:i:s", $item['lastExecutionTime_r']/1000);
            return $item;
        });
        // dd($orders);
            
        return view('ib.orders', compact('orders'));

    }

    public function cancelOrder($acctId,$orderId){
        $ib = new InteractiveBrokers;

        $ib->cancelOrder($acctId,$orderId);

        return redirect()->route('ib.orders');

    }

    public function info($conid){
        $response = Http::withOptions([
            'verify' => false,
        ])->get('https://localhost:5000/v1/api/iserver/contract/' . $conid . '/info-and-rules');

        $info = $response->json();

        return view('info', compact('info'));
    }

    public function orderstatus($orderId){
        $response = Http::withOptions([
            'verify' => false,
        ])->get('https://localhost:5000/v1/api/iserver/account/order/status/'. $orderId);

        $status = $response->json();

        // dd($status);

        return view('ib.orderstatus', compact('status'));
    }

    // public function contracts(GetContractsRequest $request){
    //     $ib = new InteractiveBrokers;
    //     $symbol = $request->symbol;
    //     $contracts = $ib->getContracts(strtoupper($symbol));
    //     // dd($contracts);
    //     return view('contracts', compact('contracts', 'symbol'));
    //     dd($contracts);
        
    // }

    public function positions(){

        $ib = new InteractiveBrokers;
        
        // $orders = $ib->orders();
        // $orders = ;
        
        $positions = $ib->getPositions(app(GeneralSettings::class)->account);
        // dd($positions);
            
        return view('ib.positions', compact('positions'));

    }


}