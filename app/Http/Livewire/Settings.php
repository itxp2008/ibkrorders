<?php

namespace App\Http\Livewire;

use App\GeneralSettings;
use App\InteractiveBrokers;
use App\Models\Order;
// use GeneralSettings;
use Livewire\Component;
use Illuminate\Support\Facades\Validator;

class Settings extends Component
{

    public $accounts, $account;

    
    protected $rules = [
        'account' => 'required'
    ];

    public function mount() {
        $ib = new InteractiveBrokers;
        $settings = app(GeneralSettings::class);

        $this->accounts = $ib->selectedAccount(true);
        // dd($this->accounts);
        if($this->accounts)
            foreach($this->accounts as $account => $selected)
                if($selected){
                    $this->account = $account;
                    
                    $settings->account = $account;

                    $settings->save();
                } 
        
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function save()
    {
        // dd($this->scan);
        $this->validate();

        $ib = new InteractiveBrokers;
        
        $status = $ib->switchAccount($this->account);

        $switch = false;

        if(is_array($status)){
            if(array_key_exists('error', $status))
                if($status['error'] == 'Account already set') $switch = true;
        
            if(array_key_exists('set', $status))
                if($status['set'])
                    $switch = true;
        }

        if($switch){
            $settings = app(GeneralSettings::class);

            $settings->account = $this->account;
            
    
            $settings->save();
    
            $this->emit('saved');
        }else $this->emit('failed');
        
    }

    public function render()
    {
        return view('livewire.settings');
    }

}


