<x-app-layout>
    <x-slot name="header">
        <h2 class="inline-flex font-semibold text-xl text-gray-800 leading-tight">
            {{ __('IBPositions') }}
        </h2>
        
    </x-slot>

    <div>
        <div class="mx-auto py-10 sm:px-6 lg:px-8">
            <div class="w-full rounded-lg shadow-lg p-4 bg-white">
                <table class="table-auto w-full border border-solid border-black border-collapse text-center">
                    <thead>
                      <tr class="border">
                        <th>acctId</th>
                        <th>conid</th>
                        <th>contractDesc</th>
                        <th>position</th>
                        <th>mktPrice</th>
                        <th>mktValue</th>
                        <th>avgCost</th>
                        <th>avgPrice</th>
                        <th>realizedPnl</th>
                        <th>unrealizedPnl</th>
                        <th>assetClass</th>
                      </tr>
                    </thead>
                    <tbody>
                        @if($positions)

                        @foreach ($positions as $position)
                        <tr class="border hover:bg-red-200">
                            <td>{{ $position['acctId'] }}</td>
                            <td>{{ $position['conid'] }}</td>
                            <td>{{ $position['contractDesc'] }}</td>
                            <td>{{ $position['position'] }}</td>
                            <td>{{ $position['mktPrice'] }}</td>
                            <td>{{ $position['mktValue'] }}</td>
                            <td>{{ $position['avgCost'] }}</td>
                            <td>{{ $position['avgPrice'] }}</td>
                            <td>{{ $position['realizedPnl'] }}</td>
                            <td>{{ $position['unrealizedPnl'] }}</td>
                            <td>{{ $position['assetClass'] }}</td>
                        </tr>
                      @endforeach
                      @endif

                    </tbody>
                  </table>
            </div>
            
        </div>
    </div>
</x-app-layout>