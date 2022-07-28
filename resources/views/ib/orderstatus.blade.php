<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Order Status') }}
        </h2>
      
    </x-slot>


    <div>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            <div class="">
                <div class="w-full rounded-lg shadow-lg p-4 bg-white">
                    <h3 class="font-semibold text-lg text-gray-700 tracking-wide">Status</h3>
                    <pre class="text-gray-500 my-1">
                        {{-- @php(dd($status)) --}}
                        {{ print_r($status) }}
                    </pre>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>