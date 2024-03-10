<div x-data="{'isModalOpen': true}" x-on:close-modal-departments="isModalOpen = false" x-on:open-modal-departments="isModalOpen = true" x-on:keydown.escape="isModalOpen=false">
    @if($user)
    <div modal-backdrop="" x-show="isModalOpen" x-cloak class="bg-gray-900/50 fixed inset-0 z-40"></div>
    <div role="dialog" tabindex="-1" x-show="isModalOpen" x-cloak x-transition tabindex="-1" aria-hidden="true" class=" overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-2xl mx-auto max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow" x-on:click.away="isModalOpen = false">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
                    <h3 class="text-xl font-semibold text-gray-900">
                        Editing Departments for {{ $this->user->name }}
                    </h3>
                    <button type="button" x-on:click="isModalOpen = false" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-4 md:p-5 space-y-4">
                    <div class="flex items-center w-full max-w-md mb-3 seva-fields formkit-fields">
                        <div class="relative w-full mr-3 formkit-field">
                            <select wire:model="departmentId" class="block w-full bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5">
                                <option value="">{{ __('- Select a department -') }}</option>
                                @foreach($unassignedDepartments as $unassignedDepartment)
                                <option value="{{ $unassignedDepartment->id }}">{{ $unassignedDepartment->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button wire:click="addDepartment">
                            <span class="px-5 py-3 text-sm font-medium text-center text-white bg-blue-700 rounded-lg cursor-pointer hover:bg-blue-800 focus:ring-4 focus:ring-blue-300">Add</span>
                        </button>
                    </div>
                    <hr>
                    <table class="text-sm table-responsive table-auto w-full hadow-md text-left rtl:text-right text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-white">
                            <tr>
                                <th class="px-2 md:px-4 py-2">ID</th>
                                <th class="px-2 md:px-4 py-2">Name</th>
                                <th class="px-2 md:px-4 py-2 text-right"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($user->departments as $department)
                            <tr wire:key="user_{{ $user->id }}" class="bg-white border-b hover:bg-gray-50">
                                <td class="px-2 md:px-4 py-2">
                                    {{ $department->id }}
                                </td>
                                <td class="px-2 md:px-4 py-2">
                                    {{ $department->name }}
                                </td>
                                <td class="px-2 md:px-4 py-2">
                                    <button type="button" wire:click="deleteUserDepartment({{ $department }})" class="float-end px-3 py-2 text-xs font-medium text-center text-white bg-red-700 hover:bg-red-800 rounded-lg focus:ring-4 focus:ring-red-300">Remove</button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- Modal footer -->
                <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b">
                    <button x-on:click="isModalOpen = false" type="button" class="py-2.5 px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100">Close</button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>