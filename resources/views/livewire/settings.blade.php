<x-jet-form-section submit="save">

    <x-slot name="title">
        {{ __('Settings') }}
    </x-slot>

    <x-slot name="description">
        {{ __('settings') }}
    </x-slot>

    <x-slot name="form">
        {{-- @php(dd($account)) --}}
        <!-- account -->
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="account" value="{{ __('account') }}" />
            <select id="account" name="account" class="mt-1 block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" wire:model="account" autocomplete="account">
                @foreach ($accounts as $account => $selected)
                    <option value="{{ $account }}" @if($selected)selected @endif>{{ $account }}</option>
                @endforeach
            </select>
            <x-jet-input-error for="account" class="mt-2" />
        </div>
        
    </x-slot>

    <x-slot name="actions">
        <x-jet-action-message class="mr-3" on="saved">
            {{ __('Saved.') }}
        </x-jet-action-message>

        <x-jet-action-message class="mr-3" on="failed">
            {{ __('Failed.') }}
        </x-jet-action-message>

        <x-jet-button>
            {{ __('Save') }}
        </x-jet-button>
    </x-slot>
</x-jet-form-section>