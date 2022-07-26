<div class="flex space-x-1 justify-around">
    {{-- <a href="{{ route('clients.edit', [$id]) }}" class="p-1 text-green-600 hover:bg-green-600 hover:text-white rounded">
        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path d="M6 3L6 21M6 3L10 7M6 3L2 7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M18 21L18 3M18 21L22 17M18 21L14 17" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
    </a> --}}

    @if($status == 'NEW')
        <a href="{{ route('orders.edit', [$id]) }}" class="p-1 text-blue-600 hover:bg-blue-600 hover:text-white rounded">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path></svg>
        </a>
    @endif

    @include('datatables::delete', ['value' => $id])
</div>