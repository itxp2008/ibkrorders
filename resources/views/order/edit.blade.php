<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit order') }}
        </h2>
    </x-slot>

    <div>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            
            <div class="md:grid md:grid-cols-3 md:gap-6">
                <div class="md:col-span-1 flex justify-between">
                    <div class="px-4 sm:px-0">
                        <h3 class="text-lg font-medium text-gray-900">Edit order</h3>
                        <p class="mt-1 text-sm text-gray-600">
                            Edit app order
                        </p>
                    </div>
                    <div class="px-4 sm:px-0"></div>
                </div>
            
                <div class="mt-5 md:mt-0 md:col-span-2">
                    <form action="{{ route('orders.update', $order) }}" method="POST">
                        @csrf
                        @method('patch')
                        <div class="px-4 py-5 bg-white sm:p-6 shadow sm:rounded-md">
                            <div class="grid grid-cols-6 gap-6">
                                                                
                                <!-- symbol -->
                                <div class="col-span-6 sm:col-span-4">
                                    <label class="block font-medium text-sm text-gray-700" for="symbol">Symbol</label>
                                    @error('symbol')
                                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                                            <strong class="font-bold">Error!</strong>
                                            <span class="block sm:inline">{{ $message }}</span>
                                            <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                                            </span>
                                        </div>
                                    @enderror
                                    <input name="symbol" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full" id="symbol" type="text" value="{{ $order->symbol }}" readonly>
                                </div>  

                                <!-- conid -->
                                <div class="col-span-6 sm:col-span-4">
                                    <label class="block font-medium text-sm text-gray-700" for="conid">conid</label>
                                    @error('conid')
                                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                                            <strong class="font-bold">Error!</strong>
                                            <span class="block sm:inline">{{ $message }}</span>
                                            <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                                            </span>
                                        </div>
                                    @enderror
                                    <input name="conid" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full" id="conid" type="text" value="{{ $order->conid }}" readonly>
                                </div>
                                                                                              
                                <!-- sec -->
                                <div class="col-span-6 sm:col-span-4">
                                    <label class="block font-medium text-sm text-gray-700" for="sec">sec</label>
                                    @error('sec')
                                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                                            <strong class="font-bold">Error!</strong>
                                            <span class="block sm:inline">{{ $message }}</span>
                                            <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                                            </span>
                                        </div>
                                    @enderror
                                    <input name="sec" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full" id="sec" type="text" value="{{ $order->sec }}" readonly>
                                </div>
                                                                                              
                                <!-- info -->
                                <div class="col-span-6 sm:col-span-4">
                                    <label class="block font-medium text-sm text-gray-700" for="info">info</label>
                                    @error('info')
                                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                                            <strong class="font-bold">Error!</strong>
                                            <span class="block sm:inline">{{ $message }}</span>
                                            <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                                            </span>
                                        </div>
                                    @enderror
                                    <input name="info" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full" id="info" type="text" value="{{ $order->info }}" readonly>
                                </div>

                                <!-- type -->
                                <div class="col-span-6 sm:col-span-4">
                                    <x-jet-label for="type" value="{{ __('type') }}" />
                                    <select id="type" name="type" class="mt-1 block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                                        <option value="STOP" @if((old('type')?old('type'):$order->type)=='STOP') selected @endif>STOP</option>
                                        <option value="STOP-LIMIT" @if((old('type')?old('type'):$order->type)=='STOP-LIMIT') selected @endif>STOP-LIMIT</option>
                                    </select>
                                    <x-jet-input-error for="type" class="mt-2" />
                                </div>

                                <!-- bar -->
                                <div class="col-span-6 sm:col-span-4">
                                    <x-jet-label for="bar" value="{{ __('bar') }}" />
                                    <select id="bar" name="bar" class="mt-1 block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                                        @foreach ($bars as $bar => $bar_length)
                                            <option value="{{ $bar }}" @if((old('bar')?old('bar'):$order->bar) == $bar) selected @endif>{{ $bar }}</option>
                                        @endforeach
                                    </select>
                                    <x-jet-input-error for="bar" class="mt-2" />
                                </div>

                                <!-- side -->
                                <div class="col-span-6 sm:col-span-4">
                                    <x-jet-label for="side" value="{{ __('side') }}" />
                                    <select id="side" name="side" class="mt-1 block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                                        <option value="BUY" @if((old('side')?old('side'):$order->type)=='BUY') selected @endif>BUY</option>
                                        <option value="SELL" @if((old('side')?old('side'):$order->type)=='SELL') selected @endif>SELL</option>
                                    </select>
                                    <x-jet-input-error for="side" class="mt-2" />
                                </div>

                                <!-- qty -->
                                <div class="col-span-6 sm:col-span-4">
                                    <label class="block font-medium text-sm text-gray-700" for="quantity">qty</label>
                                    @error('qty')
                                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                                            <strong class="font-bold">Error!</strong>
                                            <span class="block sm:inline">{{ $message }}</span>
                                            <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                                            </span>
                                        </div>
                                    @enderror
                                    <input name="qty" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full" id="qty" type="number" step='0.01' value="{{ old('qty')?old('qty'):$order->qty }}">
                                </div>

                                <!-- stop -->
                                <div class="col-span-6 sm:col-span-4">
                                    <label class="block font-medium text-sm text-gray-700" for="stop">stop</label>
                                    @error('stop')
                                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                                            <strong class="font-bold">Error!</strong>
                                            <span class="block sm:inline">{{ $message }}</span>
                                            <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                                            </span>
                                        </div>
                                    @enderror
                                    <input name="stop" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full" id="stop" type="number" step="0.01" value="{{ old('stop')?old('stop'):$order->stop }}">
                                </div>

                                <!-- limit -->
                                <div class="col-span-6 sm:col-span-4">
                                    <label class="block font-medium text-sm text-gray-700" for="limit">limit</label>
                                    @error('limit')
                                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                                            <strong class="font-bold">Error!</strong>
                                            <span class="block sm:inline">{{ $message }}</span>
                                            <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                                            </span>
                                        </div>
                                    @enderror
                                    <input name="limit" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full" id="limit" type="number" step="0.01" value="{{ old('limit')?old('limit'):$order->limit }}">
                                </div>

                                <!-- trailing -->
                                <div class="col-span-6 sm:col-span-4">
                                    <x-jet-label for="trailing" value="{{ __('trailing') }}" />
                                    <select id="trailing" name="trailing" class="mt-1 block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                                        <option value="0" @if((old('trailing')?old('trailing'):$order->trailing)=="0") selected @endif>Without trailing</option>
                                        <option value="1" @if((old('trailing')?old('trailing'):$order->trailing)=="1") selected @endif>With trailing</option>
                                    </select>
                                    <x-jet-input-error for="side" class="mt-2" />
                                </div>

                                <!-- stop_offset -->
                                <div class="col-span-6 sm:col-span-4">
                                    <label class="block font-medium text-sm text-gray-700" for="stop_offset">stop_offset</label>
                                    @error('stop_offset')
                                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                                            <strong class="font-bold">Error!</strong>
                                            <span class="block sm:inline">{{ $message }}</span>
                                            <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                                            </span>
                                        </div>
                                    @enderror
                                    <input name="stop_offset" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full" id="stop_offset" type="number" step="0.01" value="{{ old('stop_offset')?old('stop_offset'):$order->stop_offset }}">
                                </div>

                                <!-- limit_offset -->
                                <div class="col-span-6 sm:col-span-4">
                                    <label class="block font-medium text-sm text-gray-700" for="limit_offset">limit_offset</label>
                                    @error('limit_offset')
                                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                                            <strong class="font-bold">Error!</strong>
                                            <span class="block sm:inline">{{ $message }}</span>
                                            <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                                            </span>
                                        </div>
                                    @enderror
                                    <input name="limit_offset" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full" id="limit_offset" type="number" step="0.01" value="{{ old('limit_offset')?old('limit_offset'):$order->limit_offset }}">
                                </div>

                            </div>
                            
                        </div>
                        <div class="flex items-center justify-end px-4 py-3 bg-gray-50 text-right sm:px-6 shadow sm:rounded-bl-md sm:rounded-br-md">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition">
                                Save
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="hidden sm:block">
                <div class="py-8">
                    <div class="border-t border-gray-200"></div>
                </div>
            </div>
            
    </div>
</x-app-layout>