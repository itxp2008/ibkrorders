<x-app-layout>
    <x-slot name="header">
        <h2 class="inline-flex font-semibold text-xl text-gray-800 leading-tight">
            {{ __('IBOrders') }}
        </h2>
        {{-- <a class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded ml-4" href="{{ route('ib.newOrder') }}">
            new
        </a> --}}
    </x-slot>

    <div>
        <div class="mx-auto py-10 sm:px-6 lg:px-8">
            <div class="w-full rounded-lg shadow-lg p-4 bg-white">
                <table class="table-auto w-full border border-solid border-black border-collapse text-center">
                    <thead>
                      <tr class="border">
                        <th>acct</th>
                        <th>conid</th>
                        <th>orderId</th>
                        <th>sizeAndFills</th>
                        <th>ticker</th>
                        <th>status</th>
                        <th>orderType</th>
                        <th>side</th>
                        <th>timeInForce</th>
                        <th>price</th>
                        <th>auxPrice</th>
                        <th>time</th>
                        <th>cancel</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                        <tr class="border hover:bg-red-200">
                            <td>{{ $order['acct'] }}</td>
                            <td>{{ $order['conid'] }}</td>
                            <td><a href="{{ route('ib.orderstatus', $order['orderId']) }}">{{ $order['orderId'] }}</a></td>
                            <td>{{ $order['sizeAndFills'] }}</td>
                            <td>{{ $order['ticker'] }}</td>
                            <td>{{ $order['status'] }}</td>
                            <td>{{ $order['orderType'] }}</td>
                            <td>{{ $order['side'] }}</td>
                            <td>{{ $order['timeInForce'] }}</td>
                            <td>{{ $order['price']??null }}</td>
                            <td>{{ $order['auxPrice']??null }}</td>
                            <td>{{ $order['time']??null }}</td>
                            <td class="flex justify-center">
                                {{-- @php(dd()) --}}
                                @if(!in_array($order['status'],['Cancelled','Filled','Inactive']))
                                    <a href="{{ route('ib.cancelOrder', [$order['acct'], $order['orderId']]) }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </a>
                                @endif
                            </td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
            </div>
            
        </div>
    </div>
</x-app-layout>