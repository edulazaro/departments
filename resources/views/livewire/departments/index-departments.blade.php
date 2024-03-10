<div class="grid mb-2 gap-4 xl:grid-cols-1 pb-0 w-100">

    <input  wire:model.live.debounce.500ms="searchText" type="text" class="mt-4 w-100 p-2.5 bg-gray-50 border-gray-300 text-gray-900 focus:ring-blue-500 focus:border-blue-50 rounded border" placeholder="Search for a department">

    <div class="relative sm:rounded-lg overflow-visible">
        <table class="text-sm table-responsive table-auto w-full hadow-md text-left rtl:text-right text-gray-500">
            <thead class="text-xs text-gray-700 uppercase bg-white">
                <tr>
                    <th class="px-2 md:px-4 py-2">ID</th>
                    <th class="px-2 md:px-4 py-2">Name</th>
                    <th class="px-2 md:px-4 py-2">Parent</th>
                    <th class="px-2 md:px-4 py-2 text-right"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($departments as $key => $department)
                <tr wire:key="department_{{ $department->id }}" class="bg-white border-b hover:bg-gray-50">
                    <td class="px-2 md:px-4 py-2 w-16 max-w-16">
                        {{ $department->id }}
                    </td>
                    <td class="px-2 md:px-4 py-2">
                        {{ $department->name }}
                    </td>
                    <td class="px-2 md:px-4 py-2">
                        @if($department->parent)
                            {{ $department->parent->name }}
                        @endif
                    </td>
                    <td class="px-2 py-2 text-right" x-data="{ open: false }" x-on:click.outside="open = false">
                        <button id="dropdown_toggle_{{ $department->id }}" x-on:click="open = !open"class="focus:rotate-90 transition-transform mr-2 text-white focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm text-center inline-flex items-center" type="button">
                            <svg class="w-6 h-6 text-gray-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M6 12h0m6 0h0m6 0h0" />
                            </svg>
                        </button>
                        <div id="dropdown_{{$department->id}}" x-on:click="open = false" x-cloak x-show="open" x-transition.opacity class="z-10 mr-2 mt-1 right-2 absolute bg-white divide-y divide-gray-100 rounded-lg shadow w-44">
                            <ul class="py-Z text-sm text-gray-700" aria-labelledby="dropdownDefaultButton">
                                <li>
                                    <a href="#/" wire:click="$dispatch('editDepartment', { 'department' : {{ $department }} })" class="block px-4 py-2 hover:bg-gray-100">
                                        <svg class="w-5 h-5 inline-block" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m14.3 4.8 2.9 2.9M7 7H4a1 1 0 0 0-1 1v10c0 .6.4 1 1 1h11c.6 0 1-.4 1-1v-4.5m2.4-10a2 2 0 0 1 0 3l-6.8 6.8L8 14l.7-3.6 6.9-6.8a2 2 0 0 1 2.8 0Z" />
                                        </svg>
                                        <span class="inline-block ml-1">Edit</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#/" wire:click="deleteDepartment({{ $department }})" class="block px-4 py-2 hover:bg-gray-100">
                                        <svg class="w-5 h-5 inline-block" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z" />
                                        </svg>
                                        <span class="inline-block ml-1">Delete</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @if($moreRecords)
    <!-- Load more button -->
    <button type="button" wire:click="loadMore" wire:loading.attr="disabled" wire:loading.class.add="hiddens" class="text-white bg-gradient-to-br from-purple-600 to-blue-500 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">
        Load more
    </button>
    <div wire:loading wire:target="loadMore" role="status" class="text-center">

        <svg aria-hidden="true" class="m-auto w-8 h-8 text-gray-200 animate-spin fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor" />
            <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill" />
        </svg>
        <span class="sr-only">Loading...</span>
    </div>
    @endif
</div>