<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Liste des établissements par région et district</h1>

    {{-- Filters Section --}}
    <div class="flex flex-wrap gap-4 mb-6 items-end">
        <div>
            <label class="block text-sm text-gray-600 mb-1" for="region-select">Région</label>
            {{-- <select wire:model.live="selectedRegion" id="region-select" class="border rounded p-2 w-48"> --}}
                {{-- <option value="">Toutes les régions</option>
                @foreach ($filterRegions as $regionOption)
                    <option value="{{ $regionOption->id }}">{{ $regionOption->name }}</option>
                @endforeach --}}
            {{-- </select> --}}
            <select wire:model.live="selectedRegion" class="block text-sm text-gray-600 mb-1" id="select-beast" placeholder="choisir regions" autocomplete="off">
                <option value="">choisir region</option>
                @foreach ($filterRegions as $regionOption)
                    <option value="{{ $regionOption->id }}">{{ $regionOption->name }}</option>
                @endforeach 
                {{-- <option value="1">Nikola</option>
                <option value="3">Nikola Tesla</option>
                <option value="5">Arnold Schwarzenegger</option> --}}
            </select>
        </div>

        <div>
            <label class="block text-sm text-gray-600 mb-1" for="district-select">District</label>
            <select wire:model.live="selectedDistrict" id="district-select" class="border rounded p-2 w-48">
                <option value="">Tous les districts</option>
                @foreach ($filterDistricts as $districtOption)
                    <option value="{{ $districtOption->id }}">{{ $districtOption->name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm text-gray-600 mb-1" for="establishment-search">Établissement</label>
            {{-- This is the search input, dynamically bound to 'search' property with debounce --}}
            <input wire:model.debounce.500ms="search" type="text" id="establishment-search" class="border rounded p-2 w-64" placeholder="Rechercher...">
        </div>

        <div>
            <button wire:click="resetFilters" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded">
                Réinitialiser
            </button>
        </div>
    </div>
    {{-- ajout de la barre de Recherche --}}
    <div>

    </div>

    {{-- Hierarchical Table Section --}}
    <div class="overflow-x-auto rounded-lg shadow-lg">
        <table class="min-w-full bg-white border border-gray-200 text-sm text-gray-700">
            <thead class="bg-gray-100 text-gray-800 uppercase text-xs">
                <tr>
                    <th class="px-4 py-3 border-b text-left">Région</th>
                    <th class="px-4 py-3 border-b text-left">District</th>
                    <th class="px-4 py-3 border-b text-left">Établissements</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($regions as $region)
                    @php
                        // Filter districts and centers in Blade to correctly calculate rowspan based on display criteria
                        $currentRegionDistricts = $region->districts->filter(function ($district) {
                            if ($this->selectedDistrict && $district->id != $this->selectedDistrict) {
                                return false;
                            }
                            // Check if district has any centers matching search or if search is empty
                            return $district->centers->filter(function ($center) {
                                return empty($this->search) || Str::contains(Str::lower($center->name), Str::lower($this->search));
                            })->isNotEmpty() || empty($this->search);
                        });

                        // Calculate total row count for the current region for rowspan
                        $regionRowCount = 0;
                        foreach ($currentRegionDistricts as $district) {
                            $filteredCenters = $district->centers->filter(function ($center) {
                                return empty($this->search) || Str::contains(Str::lower($center->name), Str::lower($this->search));
                            });
                            $regionRowCount += max($filteredCenters->count(), 1);
                        }
                        $regionRowCount = max($regionRowCount, 1);
                        $firstRegionRow = true;
                    @endphp

                    @forelse ($currentRegionDistricts as $district)
                        @php
                            $filteredCenters = $district->centers->filter(function ($center) {
                                return empty($this->search) || Str::contains(Str::lower($center->name), Str::lower($this->search));
                            });

                            $districtRowCount = max($filteredCenters->count(), 1);
                            $firstDistrictRow = true;
                        @endphp

                        @forelse ($filteredCenters as $center)
                            <tr class="hover:bg-gray-50 transition-colors">
                                @if ($firstRegionRow)
                                    <td rowspan="{{ $regionRowCount }}" class="px-4 py-2 border-b align-top font-semibold text-indigo-600">
                                        {{ $region->name }}
                                    </td>
                                    @php $firstRegionRow = false; @endphp
                                @endif

                                @if ($firstDistrictRow)
                                    <td rowspan="{{ $districtRowCount }}" class="px-4 py-2 border-b align-top font-medium text-blue-500">
                                        {{ $district->name }}
                                    </td>
                                    @php $firstDistrictRow = false; @endphp
                                @endif

                                <td class="px-4 py-2 border-b">{{ $center->name }}</td>
                            </tr>
                        @empty
                            {{-- Case: District has no centers, or centers are filtered out by search --}}
                            <tr class="hover:bg-gray-50">
                                @if ($firstRegionRow)
                                    <td rowspan="{{ $regionRowCount }}" class="px-4 py-2 border-b align-top font-semibold text-indigo-600">
                                        {{ $region->name }}
                                    </td>
                                    @php $firstRegionRow = false; @endphp
                                @endif
                                <td class="px-4 py-2 border-b text-blue-500">{{ $district->name }}</td>
                                <td class="px-4 py-2 border-b italic text-gray-400">Aucun établissement</td>
                            </tr>
                        @endforelse
                    @empty
                        {{-- Case: Region has no districts, or districts are filtered out --}}
                        <tr class="hover:bg-gray-50">
                            @if ($firstRegionRow)
                                <td rowspan="{{ $regionRowCount }}" class="px-4 py-2 border-b align-top font-semibold text-indigo-600">
                                    {{ $region->name }}
                                </td>
                                @php $firstRegionRow = false; @endphp
                            @endif
                            <td class="px-4 py-2 border-b italic text-gray-400">Aucun district</td>
                            <td class="px-4 py-2 border-b italic text-gray-400">Aucun établissement</td>
                        </tr>
                    @endforelse
                @empty
                    {{-- Case: No regions found after all filters applied --}}
                    <tr>
                        <td colspan="3" class="text-center py-6 text-gray-500">Aucun résultat trouvé.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination Links --}}
    <div class="mt-6">
        {{ $regions->links() }}
    </div>
</div>

<script>
    new TomSelect("#select-beast",{
	create: true,
	sortField: {
		field: "text",
		direction: "asc"
	}
})
</script>