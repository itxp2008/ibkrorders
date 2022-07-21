<?php

namespace App\Console\Commands;

use App\GeneralSettings;
// use App\InteractiveBrokers;
use App\Models\Log;
use App\Models\User;
use App\Notifications\Telegram;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class Status extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ib:status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    { 
        $status = false;

        $settings = app(GeneralSettings::class);

        if(!$settings->paused){
            try {
                $response = Http::withOptions([
    
                    'verify' => false,
                    
                ])->get('https://localhost:5000/v1/api/tickle');
    
                if($response->successful()){
    
                    $status = true;       
    
                }
            }
            catch (Exception $e) {
                //code to handle the exception
                
                $status = false;
    
                $error = $e->getMessage();
                
            }
    
            if($status)
                try{
                    $response = Http::withOptions([
                        'verify' => false,
                    ])->get('https://localhost:5000/v1/api/sso/validate');
    
                    if($response->successful()){
                        
                        $status = true;
    
                    }
                }
                catch (Exception $e){
                    
                    $status = false;
    
                    $error = $e->getMessage();
    
                }
    
            if($status)
                try{
                    $response = Http::withOptions([
                        'verify' => false,
                    ])->get('https://localhost:5000/v1/api/iserver/auth/status');
    
                    if($response->successful()){
                        
                        $authenticated = $response->json('authenticated');
                        $competing = $response->json('competing');
                        $connected = $response->json('connected');
    
                    }
                }
                catch (Exception $e){
                    
                    $status = false;
    
                    $error = $e->getMessage();
    
                }
    
            if($status){
    
                if(!$authenticated || $competing || !$connected)
    
                    try{
    
                        $status = false;
    
                        $response = Http::withOptions([
                            'verify' => false,
                        ])->get('https://localhost:5000/v1/api/logout');
    
                        $response = Http::withOptions([
                            'verify' => false,
                        ])->get('https://localhost:5000/v1/api/iserver/reauthenticate');
    
                    }
    
                    catch (Exception $e){
                        
                        $status = false;
    
                        $error = $e->getMessage();
    
                    };
            }
    
            else
    
                try{
                    $response = Http::withOptions([
                        'verify' => false,
                    ])->get('https://localhost:5000/v1/api/logout');
    
                    $response = Http::withOptions([
                        'verify' => false,
                    ])->get('https://localhost:5000/v1/api/iserver/reauthenticate');
    
                }
                catch (Exception $e){
                    
                    $status = false;
    
                    $error = $e->getMessage();
    
                }
        
    
            
    
            if($status!=$settings->status){
           
                if($status)
                    $this->notify('Online');
                else $this->notify('Offline');
    
                $settings->status = $status;
                $settings->save();
    
                
            };
    
            if(isset($error)){
                $log = new Log;
                $log->name = 'error';
                $log->json = ['message' => $error];
                $log->save();
            }
        }
        

        
// dd($response->json());
        // if(!$response->json()['authenticated']){
        //     $ib = new InteractiveBrokers;
        //     $ib->notify('try reauth');
        //     $response = Http::withOptions([
        //         'verify' => false,
        //     ])->post('https://localhost:5000/v1/api/iserver/reauthenticate');
        // }
            
        // dd($response->json());
        return Command::SUCCESS;
    }

    private function notify($msg){
        $users = User::all();
        foreach($users as $user)
            try{
                $user->notify(new Telegram($msg));
            }catch (Exception $e) {

            }
    }
}