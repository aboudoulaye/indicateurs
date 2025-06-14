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
                LISTE DES DISTRICTS ({{ $nbredistricts }})
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

        <!-- Card Body -->
        <div class="card-body p-0">
            <div class="overflow-x-auto">
                <table class="table table-zebra w-full">
                    <thead>
                        <tr>
                            <th class="w-[20%]">Id</th>
                            <th class="w-[40%]">Nom</th>
                            <th class="w-[20%]">Centres</th>
                            <th class="w-[20%] text-right">Actions</th> <!-- Colonne Actions en dernière position -->
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($districts as $district)
                            <tr wire:key="{{ $district->id }}" class="hover:bg-base-200">
                                <td>{{ $district->id }}</td>
                                <td>
                                    @if ($editDistrictID === $district->id)
                                        <div class="flex flex-col">
                                            <input wire:model="editDistrictName" type="text"
                                                class="input input-bordered w-full p-2" pattern="^[A-Z\-_]+$"
                                                title="Majuscules, tirets et underscores uniquement" />
                                            @error('editDistrictName')
                                                <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    @else
                                        <div class="flex items-center gap-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                fill="currentColor" class="w-4 h-4">
                                                <path
                                                    d="M21.721 12.752a9.711 9.711 0 0 0-.945-5.003 12.754 12.754 0 0 1-4.339 2.708 18.991 18.991 0 0 1-.214 4.772 17.165 17.165 0 0 0 5.498-2.477ZM14.634 15.55a17.324 17.324 0 0 0 .332-4.647c-.952.227-1.945.347-2.966.347-1.021 0-2.014-.12-2.966-.347a17.515 17.515 0 0 0 .332 4.647 17.385 17.385 0 0 0 5.268 0ZM9.772 17.119a18.963 18.963 0 0 0 4.456 0A17.182 17.182 0 0 1 12 21.724a17.18 17.18 0 0 1-2.228-4.605ZM7.777 15.23a18.87 18.87 0 0 1-.214-4.774 12.753 12.753 0 0 1-4.34-2.708 9.711 9.711 0 0 0-.944 5.004 17.165 17.165 0 0 0 5.498 2.477ZM21.356 14.752a9.765 9.765 0 0 1-7.478 6.817 18.64 18.64 0 0 0 1.988-4.718 18.627 18.627 0 0 0 5.49-2.098ZM2.644 14.752c1.682.971 3.53 1.688 5.49 2.099a18.64 18.64 0 0 0 1.988 4.718 9.765 9.765 0 0 1-7.478-6.816ZM13.878 2.43a9.755 9.755 0 0 1 6.116 3.986 11.267 11.267 0 0 1-3.746 2.504 18.63 18.63 0 0 0-2.37-6.49ZM12 2.276a17.152 17.152 0 0 1 2.805 7.121c-.897.23-1.837.353-2.805.353-.968 0-1.908-.122-2.805-.353A17.151 17.151 0 0 1 12 2.276ZM10.122 2.43a18.629 18.629 0 0 0-2.37 6.49 11.266 11.266 0 0 1-3.746-2.504 9.754 9.754 0 0 1 6.116-3.985Z" />
                                            </svg>
                                            {{ $district->name }}
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge badge-warning p-3">
                                        {{ $district->centers->count() }}
                                    </span>
                                </td>
                                <!-- Colonne Actions déplacée en dernière position -->
                                <td class="text-right">
                                    <div class="flex justify-end gap-2">
                                        @if ($editDistrictID === $district->id)
                                            <button wire:click="update" class="btn btn-success btn-sm">
                                                Valider
                                            </button>
                                            <button wire:click="cancelEdit" class="btn btn-outline btn-error btn-sm">
                                                Annuler
                                            </button>
                                        @else
                                            <button wire:click="edit({{ $district->id }})"
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
                                                onclick="if(confirm('Êtes-vous sûr ?')) { @this.delete({{ $district->id }}) }"
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
                <option value="10">10</option>
                <option value="20">50</option>
                <option value="100">100</option>
                <option value="all">Tous</option>
            </select>

            <div class="pagination">
                {{ $districts->links() }}
            </div>
        </div>
    </div>
</div>
