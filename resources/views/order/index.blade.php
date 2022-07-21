<x-app-layout>
    <x-slot name="header">
        <h2 class="inline-flex font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Orders') }}
        </h2>
        <a class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded ml-4" href="{{ route('orders.create') }}">
            New
        </a>
    </x-slot>

    <div>
        <div class="mx-auto py-10 sm:px-6 lg:px-8">
            <livewire:order-datatables
            sort="id"
            {{-- exportable --}}
            />

        </div>
    </div>
</x-app-layout>