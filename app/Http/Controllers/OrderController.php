<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\InteractiveBrokers;
use App\Models\Order;
use Illuminate\Http\Request;


class OrderController extends Controller
{
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
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('order.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
        if($symbol = strtoupper($request->query('symbol'))){
            if($conid = $request->query('conid')){
                $info = $request->query('info');
                $sec = $request->query('sec');

                $bars = $this->bars;

                return view('order.create', compact('symbol', 'conid', 'sec', 'info', 'bars'));
            }else{
                $ib = new InteractiveBrokers;
                $stks = $ib->getSTKContracts($symbol);
                $futs = $ib->getFUTContracts($symbol);

                return view('order.conid', compact('symbol', 'stks', 'futs'));
            }
        }
        else return view('order.symbol');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreOrderRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreOrderRequest $request)
    {
        //
        $order = new Order;

        $order->symbol = $request->symbol;
        $order->conid = $request->conid;
        $order->sec = $request->sec;
        $order->info = $request->info;
        $order->type = $type = $request->type;
        $order->bar = $bar = $request->bar;
        $order->bar_length = $this->bars[$bar];
        $order->side = $request->side;
        $order->qty = $request->qty;
        $order->stop = $request->stop;
        if($type == 'STOP-LIMIT') $order->limit = $request->limit;
        $order->trailing = $trailing = $request->trailing;
        if($trailing){
            $order->stop_offset = $request->stop_offset;
            if($type == 'STOP-LIMIT') $order->limit_offset = $request->limit_offset;
        }
        $order->status = 'NEW';

        $order->save();

        return redirect()->route('orders.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateOrderRequest  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateOrderRequest $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }
}
