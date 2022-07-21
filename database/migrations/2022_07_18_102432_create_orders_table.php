<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('symbol');
            $table->string('conid');
            $table->string('sec');
            $table->string('info');
            $table->string('type');
            $table->string('bar');
            $table->string('bar_length');
            $table->string('side');
            $table->float('qty',8,2);
            $table->float('stop',8,2);
            $table->float('limit',8,2)->nullable();
            $table->boolean('trailing',8,2);
            $table->float('stop_offset',8,2)->nullable();
            $table->float('limit_offset',8,2)->nullable();
            // $table->order(
            $table->string('status');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
};
