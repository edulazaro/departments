<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <div class="flex">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight w-auto">{{ __('Users') }}</h2>
            </div>
            <div class="sm:flex sm:items-center sm:ms-6">
                <livewire:users.add-user/>
            </div>
    </x-slot>

    <div class="pb-10 mt-6">
        <div class="max-w-screen-xl mx-auto sm:px-6 lg:px-8">
            <div class="sm:rounded-lg">
                <livewire:users.index-users />
            </div>
        </div>
    </div>
</x-app-layout>
