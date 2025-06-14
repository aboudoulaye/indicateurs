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
        <div class="flex flex-wrap justify-between items-center mb-4 gap-2">
            <span class="badge badge-warning font-semibold p-3">
                ENREGISTREMENT DE {{$period->period}}
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
                <table class="table-auto w-full border">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="border px-2 py-1">ID</th>
                            <th class="border px-2 py-1">Centres</th>
                            <th class="border px-2 py-1">Produit</th>
                            <th class="border px-2 py-1">Stock initial</th>
                            <th class="border px-2 py-1">Qté reçue</th>
                            <th class="border px-2 py-1">Qté distribuée</th>
                            <th class="border px-2 py-1">Perte et Ajustement</th>
                            <th class="border px-2 py-1">SDU</th>
                            <th class="border px-2 py-1">CMM</th>
                            <th class="border px-2 py-1">Nombre jours rupture</th>
                            <th class="border px-2 py-1">Qté Proposée</th>
                            <th class="border px-2 py-1">Qté Approuvée</th>
                            <th class="border px-2 py-1">Qté commandée</th>
                            <!-- Ajoute d'autres colonnes si nécessaire -->
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($productRecords as $productRecord)
                            <tr>
                                <td class="border px-2 py-1">{{ $productRecord->id }}</td>
                                <td class="border px-2 py-1">{{ $productRecord->record->center->name ?? 'Centre inconnu' }}</td>
                                <td class="border px-2 py-1">{{ $productRecord->product->name ?? 'N/A' }}</td>
                                <td class="border px-2 py-1">{{ $productRecord->stock_initial }}</td>
                                <td class="border px-2 py-1">{{ $productRecord->qte_recu }}</td>
                                <td class="border px-2 py-1">{{ $productRecord->qte_distribuée }}</td>
                                <td class="border px-2 py-1">{{ $productRecord->perte_ajustement }}</td>
                                <td class="border px-2 py-1">{{ $productRecord->sdu }}</td>
                                <td class="border px-2 py-1">{{ $productRecord->cmm }}</td>
                                <td class="border px-2 py-1">{{ $productRecord->nbr_jrs }}</td>
                                <td class="border px-2 py-1">{{ $productRecord->qte_proposee }}</td>
                                <td class="border px-2 py-1">{{ $productRecord->qte_cmde }}</td>
                                <td class="border px-2 py-1">{{ $productRecord->qte_approuve }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="flex flex-wrap justify-between items-center mt-4 pt-4 border-t border-base-300 gap-2">
            <select wire:model.live="perPage" class="select select-bordered select-sm w-full max-w-[120px]">
                <option value="20">20</option>
                <option value="100">100</option>
                <option value="500">500</option>
                <option value="all">Tous</option>
            </select>

            <div class="pagination">
                {{ $productRecords->links() }}
            </div>
        </div>
    </div>
    </div>
