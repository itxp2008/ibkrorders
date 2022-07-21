<?php

namespace App\Http\Livewire;

use App\Jobs\FetchBalance;
use App\Models\Order;
use Mediconesystems\LivewireDatatables\Action;
use Mediconesystems\LivewireDatatables\BooleanColumn;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\NumberColumn;

class OrderDatatables extends LivewireDatatable
{

    public $model = Order::class;
//     public function builder()
// {
//     return Client::query()
//         ->join('balances', 'clients.id', 'balances.client_id', 'right outer');
//     }

    public function columns()
    {
        //
        return [
            // Column::checkbox(),

            NumberColumn::name('id'),

            Column::name('symbol')
                ->filterable(),

            Column::name('conid')
                ->filterable(),

            Column::name('sec')
                ->filterable(),

            Column::name('info')
                ->filterable(),

            Column::name('type')
                ->filterable(),

            Column::name('bar')
                ->filterable(),

            Column::name('side')
                ->filterable(),

            NumberColumn::name('qty')
                ->filterable(),

            NumberColumn::name('stop')
                ->filterable(),

            NumberColumn::name('limit')
                ->filterable(),

            BooleanColumn::name('trailing')
                ->filterable(),

            NumberColumn::name('stop_offset')
            ->filterable(),

            NumberColumn::name('limit_offset')
                ->filterable(),
            
            Column::name('status')
                ->filterable(),

            // Column::name('balances.asset')
            //     ->filterable(),

            // NumberColumn::name('balances.free')
            //     ->filterable(),

            // NumberColumn::name('balances.used')
            //     ->filterable(),

            // NumberColumn::name('balances.total')
            //     ->filterable(),

            // Column::callback(['free'], function ($json) {
            //     if(is_array($array = json_decode($json, true)))
            //         return http_build_query($array, '', '<br>');
            // })->label('free')->filterable(),

            // Column::callback(['used'], function ($json) {
            //     if(is_array($array = json_decode($json, true)))
            //         return http_build_query($array, '', '<br>');
            // })->label('used')->filterable(),

            // Column::callback(['total'], function ($json) {
            //     if(is_array($array = json_decode($json, true)))
            //         return http_build_query($array, '', '<br>');
            // })->label('total')->filterable(),

            
            DateColumn::name('created_at')
                ->format('Y-m-d H:i:s'),
                // ->label('createdAt')

            DateColumn::name('updated_at')
                ->format('Y-m-d H:i:s'),
                // ->label('createdAt')

            // Column::callback(['id'], function ($id) {
            //         return view('table-actions', ['id' => $id]);
            // })->unsortable()
                
        ];

    }

    public function buildActions()
    {
        return [

            Action::value('order')->label('Create order')->callback(function ($mode, $items) {
                // $items contains an array with the primary keys of the selected items
                // dd($items);
                return redirect()->route('orders.create')->with( ['ids' => $items] );

                // return view('order.create', compact('items'));

                // app()->call('App\Http\Controllers\OrderController@create',  [
                //     "ids" => $items
                // ]);
            }),

            Action::value('balance')->label('Refresh balance')->callback(function ($mode, $items) {
                // $items contains an array with the primary keys of the selected items
                // dd($items);
                // return redirect()->route('orders.create')->with( ['ids' => $items] );

                // dd($items);
                foreach($items as $item)
                    FetchBalance::dispatch(Client::findOrFail($item));

                // return view('order.create', compact('items'));

                // app()->call('App\Http\Controllers\OrderController@create',  [
                //     "ids" => $items
                // ]);
            }),

            
        ];
    }
}