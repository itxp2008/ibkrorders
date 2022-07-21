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
                    <form action="{{ route('orders.create') }}" method="get">
                        {{-- @csrf --}}
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
                                    <input name="symbol" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full" id="symbol" type="text" value="{{ old('symbol') }}">
                                </div>

                                {{-- <!-- orderType -->
                                <div class="col-span-6 sm:col-span-4">
                                    <x-jet-label for="orderType" value="{{ __('orderType') }}" />
                                    <select id="orderType" name="orderType" class="mt-1 block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                                        @foreach ($orderType as $type => $label)
                                            <option value="{{ $type }}" @if(old('orderType')==$type) selected @endif>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                    <x-jet-input-error for="orderType" class="mt-2" />
                                </div> --}}

                                {{-- <!-- side -->
                                <div class="col-span-6 sm:col-span-4">
                                    <x-jet-label for="side" value="{{ __('side') }}" />
                                    <select id="side" name="side" class="mt-1 block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                                        @foreach ($side as $side => $label)
                                            <option value="{{ $side }}" @if(old('side')==$side) selected @endif>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                    <x-jet-input-error for="side" class="mt-2" />
                                </div>

                                <!-- quantity -->
                                <div class="col-span-6 sm:col-span-4">
                                    <label class="block font-medium text-sm text-gray-700" for="quantity">quantity</label>
                                    @error('quantity')
                                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                                            <strong class="font-bold">Error!</strong>
                                            <span class="block sm:inline">{{ $message }}</span>
                                            <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                                            </span>
                                        </div>
                                    @enderror
                                    <input name="quantity" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full" id="quantity" type="number" step='0.01' value="{{ old('quantity') }}">
                                </div>

                                <!-- tif -->
                                <div class="col-span-6 sm:col-span-4">
                                    <x-jet-label for="tif" value="{{ __('tif') }}" />
                                    <select id="tif" name="tif" class="mt-1 block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                                        @foreach ($tif as $key => $value)
                                            <option value="{{ $key }}" @if(old('tif')==$key) selected @endif>{{ $value }}</option>
                                        @endforeach
                                    </select>
                                    <x-jet-input-error for="tif" class="mt-2" />
                                </div>

                                <!-- price -->
                                <div class="col-span-6 sm:col-span-4">
                                    <label class="block font-medium text-sm text-gray-700" for="price">price (limit price in case of LIMIT/STOP-LIMIT or stop price in case of STOP order)</label>
                                    @error('price')
                                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                                            <strong class="font-bold">Error!</strong>
                                            <span class="block sm:inline">{{ $message }}</span>
                                            <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                                            </span>
                                        </div>
                                    @enderror
                                    <input name="price" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full" id="price" type="number" step="0.01" value="{{ old('price') }}">
                                </div>

                                <!-- auxPrice -->
                                <div class="col-span-6 sm:col-span-4">
                                    <label class="block font-medium text-sm text-gray-700" for="auxPrice">auxPrice (stop price for STOP-LIMIT orders)</label>
                                    @error('auxPrice')
                                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                                            <strong class="font-bold">Error!</strong>
                                            <span class="block sm:inline">{{ $message }}</span>
                                            <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                                            </span>
                                        </div>
                                    @enderror
                                    <input name="auxPrice" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full" id="auxPrice" type="number" step="0.01" value="{{ old('auxPrice') }}">
                                </div>

                                <!-- outside_rth -->
                                <div class="col-span-6 sm:col-span-4">
                                    <x-jet-label for="outside_rth" value="{{ __('Try outside RTH(Just for Limit/Stop-Limit with ContratRules)') }}" />
                                    <select id="outside_rth" name="outside_rth" class="mt-1 block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" wire:model="outside_rth" autocomplete="outside_rth">
                                        <option value='1' @if(old('outside_rth')==1) selected @endif>YES</option>
                                        <option value='0' @if(old('outside_rth')==0) selected @endif>NO</option>
                                    </select>
                                    <x-jet-input-error for="outside_rth" class="mt-2" />
                                </div> --}}

                            </div>
                            
                        </div>
                        <div class="flex items-center justify-end px-4 py-3 bg-gray-50 text-right sm:px-6 shadow sm:rounded-bl-md sm:rounded-br-md">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition">
                                Search
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