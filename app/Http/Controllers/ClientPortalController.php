<?php

namespace App\Http\Controllers;

use App\GeneralSettings;
use App\InteractiveBrokers;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redis;

class ClientPortalController extends Controller
{
    //
    public function status(){
        $ib = new InteractiveBrokers;
        $status = $ib->status();
        $accounts = [];
        if($status) $accounts = $ib->accounts();
        else $status = ['Error' => 'Check clientportal or relogin'];

        // try{
        //     $response = Http::withOptions([
        //         'verify' => false,
        //     ])->get('https://localhost:5000/v1/api/iserver/auth/status');
        //     if($response->failed()) $status = ['CP GW Login req' => 'status=' . $response->status()];
        //     else {
        //         $status = $response->json();
        //         $response = Http::withOptions([
        //             'verify' => false,
        //         ])->get('https://localhost:5000/v1/api/portfolio/accounts');
        //         $accounts = $response->json();
        //     }
        // }
        // catch(Exception $e){
        //     $status = ['Error' => $e->getMessage()];
        // }



        
        // dd($response->clientError());

        // if(is_object($status)){
        //     $status = (array) $status;
        // }
        // else $status = ['Error' => $status];
        $settings = app(GeneralSettings::class);
        $clientportal = Redis::get('clientportal');

        return view('status', compact('status', 'accounts', 'settings', 'clientportal'));
    } 

    public function start(){
        Redis::set('clientportal', 'start');

        return redirect()->route('clientportal.status');
    }

    public function stop(){
        Redis::set('clientportal', 'stop');

        $settings = app(GeneralSettings::class);

        $settings->status = false;
        $settings->paused = true;
        $settings->save();

        InteractiveBrokers::notify('Offline');

        return redirect()->route('clientportal.status');

    }

    public function logout(){
        
        $response = Http::withOptions([
            'verify' => false,
        ])->get('https://localhost:5000/v1/api/logout');

        return redirect()->route('clientportal.status');

    }

    public function reauth(){
        
        $response = Http::withOptions([
            'verify' => false,
        ])->get('https://localhost:5000/v1/api/iserver/reauthenticate');

        return redirect()->route('clientportal.status');

    }

    public function statusStart(){
        
        $settings = app(GeneralSettings::class);

        $settings->paused = false;
        $settings->save();

        return redirect()->route('clientportal.status');

    }

    public function statusStop(){

        $settings = app(GeneralSettings::class);

        $settings->status = false;
        $settings->paused = true;
        $settings->save();

        InteractiveBrokers::notify('Offline');

        return redirect()->route('clientportal.status');

    }
    

}