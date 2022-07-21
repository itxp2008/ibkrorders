<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create order') }}
        </h2>
    </x-slot>

    <div>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            
            <div class="md:grid md:grid-cols-3 md:gap-6">
                <div class="md:col-span-1 flex justify-between">
                    <div class="px-4 sm:px-0">
                        <h3 class="text-lg font-medium text-gray-900">New order</h3>
                        <p class="mt-1 text-sm text-gray-600">
                            CONID Search
                        </p>
                    </div>
                    <div class="px-4 sm:px-0"></div>
                </div>
            
                <div class="mt-5 md:mt-0 md:col-span-2">
                    <div class="px-4 py-5 bg-white sm:p-6 shadow sm:rounded-md">
                            <div>Stocks</div>
                            @foreach ($stks as $stk)
                                @foreach ($stk['contracts'] as $contract)
                                    <div><a class="hover:bg-violet-200" href="{{ route('orders.create', ['symbol' => $symbol, 'conid' => $contract['conid'], 'sec' => 'STK', 'info' => $stk['name']]) }}">{{ $stk['name'] }} | {{ $contract['exchange'] }}</a></div>
                                @endforeach
                            @endforeach
                            <br/>
                            <div>Futures</div>
                            @foreach ($futs as $fut)
                                <div><a class="hover:bg-violet-200" href="{{ route('orders.create', ['symbol' => $fut['symbol'], 'conid' => $fut['conid'], 'sec' => 'FUT', 'info' => $fut['expirationDate']]) }}">{{ $fut['symbol'] }} {{ $fut['expirationDate'] }}</a>
                            @endforeach
                    </div>
                </div>
            </div>
            <div class="hidden sm:block">
                <div class="py-8">
                    <div class="border-t border-gray-200"></div>
                </div>
            </div>
            
    </div>
</x-app-layout>