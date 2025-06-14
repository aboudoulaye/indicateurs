<div class="principal w-full ">
    <!-- Card Container -->
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
            <!-- Card Header avec bouton Excel -->
            <div class="flex flex-wrap justify-between items-center mb-4 gap-2">
                <span class="badge badge-warning font-semibold p-3">
                    LISTE DES RÉGIONS ({{ $nbreregions }})
                </span>

                <div class="flex items-center gap-2">
                    <!-- Bouton Excel -->
                    <button wire:click="export" class="btn btn-success btn-md flex items-center gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                            <path fill-rule="evenodd"
                                d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25ZM9 7.5A.75.75 0 0 0 9 9h1.5c.98 0 1.813.626 2.122 1.5H9A.75.75 0 0 0 9 12h3.622a2.251 2.251 0 0 1-2.122 1.5H9a.75.75 0 0 0-.53 1.28l3 3a.75.75 0 1 0 1.06-1.06L10.8 14.988A3.752 3.752 0 0 0 14.175 12H15a.75.75 0 0 0 0-1.5h-.825A3.733 3.733 0 0 0 13.5 9H15a.75.75 0 0 0 0-1.5H9Z"
                                clip-rule="evenodd" />
                        </svg>
                        Excel
                    </button>

                    <label class="input input-bordered flex items-center floating-label gap-2">
                        <span>Rechercher...</span>
                        <svg class="w-4 h-4 opacity-70" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <g stroke-linejoin="round" stroke-linecap="round" stroke-width="2.5" fill="none"
                                stroke="currentColor">
                                <circle cx="11" cy="11" r="8"></circle>
                                <path d="m21 21-4.3-4.3"></path>
                            </g>
                        </svg>
                        <input type="search" required wire:model.live="search" placeholder="Rechercher..."
                            class="grow" />
                    </label>
                </div>
            </div>

            
            <div class="card-body p-0">
                <div class="overflow-x-auto">
                    <table class="table table-zebra w-full">
                        <thead>
                            <tr>
                                <th class="w-[10%] text-center">Id</th>
                                <th class="w-[30%]">Nom</th>
                                <th class="w-[15%] text-center">Districts</th>
                                <th class="w-[15%] text-center">Centres</th>
                                <th class="w-[30%] text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($regions as $region)
                                <tr wire:key="{{ $region->id }}" class="hover:bg-base-200">
                                    <td class="text-center">{{ $region->id }}</td>
                                    <td>
                                        @if ($editRegionID === $region->id)
                                            <div class="flex flex-col">
                                                <input wire:model="editRegionName" type="text"
                                                    class="input input-bordered w-full p-2" pattern="^[A-Z\-_]+$"
                                                    title="Majuscules, tirets et underscores uniquement" />
                                                @error('editRegionName')
                                                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        @else
                                            <div class="flex items-center gap-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                    fill="currentColor" class="size-4">
                                                    <path fill-rule="evenodd"
                                                        d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25ZM8.547 4.505a8.25 8.25 0 1 0 11.672 8.214l-.46-.46a2.252 2.252 0 0 1-.422-.586l-1.08-2.16a.414.414 0 0 0-.663-.107.827.827 0 0 1-.812.21l-1.273-.363a.89.89 0 0 0-.738 1.595l.587.39c.59.395.674 1.23.172 1.732l-.2.2c-.211.212-.33.498-.33.796v.41c0 .409-.11.809-.32 1.158l-1.315 2.191a2.11 2.11 0 0 1-1.81 1.025 1.055 1.055 0 0 1-1.055-1.055v-1.172c0-.92-.56-1.747-1.414-2.089l-.654-.261a2.25 2.25 0 0 1-1.384-2.46l.007-.042a2.25 2.25 0 0 1 .29-.787l.09-.15a2.25 2.25 0 0 1 2.37-1.048l1.178.236a1.125 1.125 0 0 0 1.302-.795l.208-.73a1.125 1.125 0 0 0-.578-1.315l-.665-.332-.091.091a2.25 2.25 0 0 1-1.591.659h-.18c-.249 0-.487.1-.662.274a.931.931 0 0 1-1.458-1.137l1.279-2.132Z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                                {{ $region->name }}
                                            </div>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <span class="badge badge-info py-2 px-3 rounded-lg">
                                            {{ $region->districts->count() }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge badge-warning py-2 px-3 rounded-lg">
                                            {{ $region->districts->sum(fn($district) => $district->centers->count()) }}
                                        </span>
                                    </td>
                                    <td class="text-right">
                                        <div class="flex justify-end gap-2">
                                            @if ($editRegionID === $region->id)
                                                <button wire:click="update" class="btn btn-success btn-sm py-1 px-3">
                                                    Valider
                                                </button>
                                                <button wire:click="cancelEdit"
                                                    class="btn btn-outline btn-error btn-sm py-1 px-3">
                                                    Annuler
                                                </button>
                                            @else
                                                <button wire:click="edit({{ $region->id }})"
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
                                                    onclick="if(confirm('Êtes-vous sûr ?')) { @this.delete({{ $region->id }}) }"
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
                    <option value="5">5</option>
                    <option value="20">20</option>
                    <option value="all">Tous</option>
                </select>
                <div class="pagination">
                    {{ $regions->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
</div>
