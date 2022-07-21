<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Status') }}
        </h2>
        
        {{-- <div class="flex justify-center">
            <div class="form-check form-switch">
              <input class="form-check-input appearance-none w-9 -ml-10 rounded-full float-left h-5 align-top bg-white bg-no-repeat bg-contain bg-gray-300 focus:outline-none cursor-pointer shadow-sm" type="checkbox" role="switch" id="flexSwitchCheckDefault">
              <label class="form-check-label inline-block text-gray-800" for="flexSwitchCheckDefault">Default switch checkbox input</label>
            </div>
          </div> --}}
    </x-slot>


    <div>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            <div class="mb-6">
                @if($clientportal == 'stop')<a href="{{ route('clientportal.start') }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">START CP</a>@endif
                @if($clientportal == 'start')<a href="{{ route('clientportal.stop') }}" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">STOP CP</a>@endif
                <a href="{{ route('clientportal.logout') }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">LOGOUT</a>
                <a href="{{ route('clientportal.reauth') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">REAUTH</a>
                @if(!$settings->paused)<a href="{{ route('clientportal.status-stop') }}" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">STOP A_REAUTH</a>@endif
                @if($settings->paused)<a href="{{ route('clientportal.status-start') }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">START A_REAUTH</a>@endif
                {{-- @if($settings->scan)<a href="{{ route('clientportal.scan-off') }}" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">SCAN OFF</a>@endif
                @if(!$settings->scan)<a href="{{ route('clientportal.scan-on') }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">SCAN ON</a>@endif --}}
                
            </div>

            <div class="gap-4">
                <div class="w-full rounded-lg shadow-lg p-4 bg-white mb-6">
                    <h3 class="font-semibold text-lg text-gray-700 tracking-wide">Status</h3>
                    <pre class="text-gray-500 my-1">
                        {{-- @php(dd($status)) --}}
                        {{ print_r($status) }}
                    </pre>
                </div>
                
                <div class=" w-full rounded-lg shadow-lg p-4 bg-white">
                    <h3 class="font-semibold text-lg text-gray-700 tracking-wide">Accounts</h3>
                    <pre class="text-gray-500 my-1" style="overflow: scroll">
                        {{-- @php(dd($status)) --}}
                        {{ print_r($accounts) }}
                    </p>
                </div>
                
            </div>
        </div>
    </div>
</x-app-layout>