<div class="w-full">
    <!-- Notifications -->
    @if (session()->has('message'))
        <div x-data="{ show: true }" x-show="show" x-transition.duration.300ms x-init="setTimeout(() => show = false, 5000)"
            class="fixed top-4 right-4 z-50">
            <div class="alert alert-success flex justify-between items-center max-w-md p-4 rounded-lg shadow-lg">
                <span>{{ session('message') }}</span>
                <button @click="show = false" class="text-white hover:text-red-400 text-xl font-bold ml-4"
                    aria-label="Fermer">
                    &times;
                </button>
            </div>
        </div>
    @endif
    @if (session()->has('status'))
        <div x-data="{ show: true }" x-show="show" x-transition.duration.300ms x-init="setTimeout(() => show = false, 5000)"
            class="fixed top-4 right-4 z-50">
            <div class="alert alert-error flex justify-between items-center max-w-md p-4 rounded-lg shadow-lg">
                <span>{{ session('status') }}</span>
                <button @click="show = false" class="text-white hover:text-red-400 text-xl font-bold ml-4"
                    aria-label="Fermer">
                    &times;
                </button>
            </div>
        </div>
    @endif

    <!-- Card Container -->
    <div class="bg-base-100 rounded-xl shadow-md p-4 mt-4 w-full">
        <!-- Card Header -->
        <div class="flex flex-wrap justify-between items-center mb-4 gap-2">
            <span class="badge badge-warning font-semibold p-3">
                LISTE DES PROGRAMMES ({{ $nbreprogrammes }})
            </span>

            <div class="flex items-center gap-2">
                <button wire:click="export" class="btn btn-success btn-md grow flex items-center gap-1">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                        <path fill-rule="evenodd"
                            d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25ZM9 7.5A.75.75 0 0 0 9 9h1.5c.98 0 1.813.626 2.122 1.5H9A.75.75 0 0 0 9 12h3.622a2.251 2.251 0 0 1-2.122 1.5H9a.75.75 0 0 0-.53 1.28l3 3a.75.75 0 1 0 1.06-1.06L10.8 14.988A3.752 3.752 0 0 0 14.175 12H15a.75.75 0 0 0 0-1.5h-.825A3.733 3.733 0 0 0 13.5 9H15a.75.75 0 0 0 0-1.5H9Z"
                            clip-rule="evenodd" />
                    </svg>
                    Excel
                </button>
    
                <label class="input input-bordered flex items-center gap-2">
                    <svg class="w-4 h-4 opacity-70" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <g stroke-linejoin="round" stroke-linecap="round" stroke-width="2.5" fill="none"
                            stroke="currentColor">
                            <circle cx="11" cy="11" r="8"></circle>
                            <path d="m21 21-4.3-4.3"></path>
                        </g>
                    </svg>
                    <input type="search" required wire:model.live="search" placeholder="Rechercher..." class="grow" />
                </label>
            </div>
        </div>

        <!-- Card Body -->
        <div class="card-body p-0">
            <div class="overflow-x-auto">
                <table class="table table-zebra w-full">
                    <thead>
                        <tr>
                            <th class="w-[10%]">Id</th>
                            <th class="w-[20%]">Code</th>
                            <th class="w-[30%]">Nom</th>
                            <th class="w-[20%] text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($programmes as $programme)
                            <tr wire:key="{{ $programme->id }}" class="hover:bg-base-200">
                                <td>{{ $programme->id }}</td>
                                <td>{{ $programme->code }}</td>
                                <td>
                                    @if ($editProgrammeID === $programme->id)
                                        <div class="flex flex-col">
                                            <input wire:model="editProgrammeName" type="text"
                                                class="input input-bordered w-full p-2" pattern="^[A-Z\-_]+$"
                                                title="Majuscules, tirets et underscores uniquement" />
                                            @error('editCenterName')
                                                <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    @else
                                        <div class="flex items-center gap-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                fill="currentColor" class="size-4">
                                                <path
                                                    d="M19.006 3.705a.75.75 0 1 0-.512-1.41L6 6.838V3a.75.75 0 0 0-.75-.75h-1.5A.75.75 0 0 0 3 3v4.93l-1.006.365a.75.75 0 0 0 .512 1.41l16.5-6Z" />
                                                <path fill-rule="evenodd"
                                                    d="M3.019 11.114 18 5.667v3.421l4.006 1.457a.75.75 0 1 1-.512 1.41l-.494-.18v8.475h.75a.75.75 0 0 1 0 1.5H2.25a.75.75 0 0 1 0-1.5H3v-9.129l.019-.007ZM18 20.25v-9.566l1.5.546v9.02H18Zm-9-6a.75.75 0 0 0-.75.75v4.5c0 .414.336.75.75.75h3a.75.75 0 0 0 .75-.75V15a.75.75 0 0 0-.75-.75H9Z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            {{ $programme->name }}
                                        </div>
                                    @endif
                                </td>
                                <td class="text-right">
                                    <div class="flex justify-end gap-2">
                                        @if ($editProgrammeID === $Programme->id)
                                            <button wire:click="update" class="btn btn-success btn-sm">
                                                Valider
                                            </button>
                                            <button wire:click="cancelEdit" class="btn btn-outline btn-error btn-sm">
                                                Annuler
                                            </button>
                                        @else
                                            <button wire:click="edit({{ $programme->id }})"
                                                class="btn btn-ghost btn-square">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                    fill="currentColor" class="w-5 h-5 text-blue-600">
                                                    <path
                                                        d="M21.731 2.269a2.625 2.625 0 0 0-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 0 0 0-3.712ZM19.513 8.199l-3.712-3.712-8.4 8.4a5.25 5.25 0 0 0-1.32 2.214l-.8 2.685a.75.75 0 0 0 .933.933l2.685-.8a5.25 5.25 0 0 0 2.214-1.32l8.4-8.4Z" />
                                                    <path
                                                        d="M5.25 5.25a3 3 0 0 0-3 3v10.5a3 3 0 0 0 3 3h10.5a3 3 0 0 0 3-3V13.5a.75.75 0 0 0-1.5 0v5.25a1.5 1.5 0 0 1-1.5 1.5H5.25a1.5 1.5 0 0 1-1.5-1.5V8.25a1.5 1.5 0 0 1 1.5-1.5h5.25a.75.75 0 0 0 0-1.5H5.25Z" />
                                                </svg>
                                            </button>
                                            <button
                                                onclick="if(confirm('Êtes-vous sûr ?')) { @this.delete({{ $programme->id }}) }"
                                                class="btn btn-ghost btn-square">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                    fill="currentColor" class="w-5 h-5 text-red-600">
                                                    <path fill-rule="evenodd"
                                                        d="M16.5 4.478v.227a48.816 48.816 0 0 1 3.878.512.75.75 0 1 1-.256 1.478l-.209-.035-1.005 13.07a3 3 0 0 1-2.991 2.77H8.084a3 3 0 0 1-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 0 1-.256-1.478A48.567 48.567 0 0 1 7.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 0 1 3.369 0c1.603.051 2.815 1.387 2.815 2.951Zm-6.136-1.452a51.196 51.196 0 0 1 3.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 0 0-6 0v-.113c0-.794.609-1.428 1.364-1.452Zm-.355 5.945a.75.75 0 1 0-1.5.058l.347 9a.75.75 0 1 0 1.499-.058l-.346-9Zm5.48.058a.75.75 0 1 0-1.498-.058l-.347 9a.75.75 0 0 0 1.5.058l.345-9Z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Card Footer -->
        <div class="flex flex-wrap justify-between items-center mt-4 pt-4 border-t border-base-300 gap-2">
            <select wire:model.live="perPage" class="select select-bordered select-sm w-full max-w-[120px]">
                <option value="100">100</option>
                <option value="500">500</option>
                <option value="5000">5000</option>
                <option value="all">Tous</option>
            </select>

            <div class="pagination">
                {{ $programmes->links() }}
            </div>
        </div>
    </div>
</div>
