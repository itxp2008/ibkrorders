<?php

namespace App\Http\Livewire;

use App\Models\Log;
use Mediconesystems\LivewireDatatables\BooleanColumn;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\NumberColumn;

class LogsDatatables extends LivewireDatatable
{

    public $model = Log::class;

    public function columns()
    {
        //
        return [
            NumberColumn::name('id')
                ->label('ID'),

            Column::name('name')
                ->filterable()
                ->label('name'),

            Column::callback(['json'], function ($json) {
                return nl2br(print_r(json_decode($json, true),true));
            })->label('json'),
            

            DateColumn::name('created_at')
                ->format('Y-m-d H:i:s')
                ->label('createdAt')

                
        ];

    }
}