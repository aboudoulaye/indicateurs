<?php

namespace App\Livewire\Tous;

use App\Models\District;
use App\Models\Region;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Str; // Import Str for case-insensitive search

class TousList extends Component
{
    use WithPagination;

    // Public properties that will be bound to the filter inputs in the Blade view
    public string $selectedRegion = '';
    public string $selectedDistrict = '';
    public string $search = '';

    // Query string parameters to keep filters in the URL when navigating or refreshing
    protected $queryString = [
        'selectedRegion' => ['except' => ''],
        'selectedDistrict' => ['except' => ''],
        'search' => ['except' => ''],
    ];

    /**
     * Resets pagination when any filter changes.
     * This method is automatically called by Livewire when `selectedRegion` is updated.
     */
    public function updatedSelectedRegion(): void
    {
        $this->selectedDistrict = ''; // Reset district when region changes
        $this->resetPage();
    }

    /**
     * Resets pagination when the district filter changes.
     * This method is automatically called by Livewire when `selectedDistrict` is updated.
     */
    public function updatedSelectedDistrict(): void
    {
        $this->resetPage();
    }

    /**
     * Resets pagination when the search input changes.
     * This method is automatically called by Livewire when `search` is updated (after debounce).
     */
    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    /**
     * Resets all filters and pagination.
     */
    public function resetFilters(): void
    {
        $this->selectedRegion = '';
        $this->selectedDistrict = '';
        $this->search = '';
        $this->resetPage();
    }

    /**
     * Renders the Livewire component view.
     * This method is called whenever Livewire detects a change in component state.
     */
    public function render()
    {
        $regionsQuery = Region::query();

        // Apply region filter if selected
        if ($this->selectedRegion) {
            $regionsQuery->where('id', $this->selectedRegion);
        }

        // Eager load districts and centers, applying constraints directly in the database
        $regionsQuery->with(['districts' => function ($districtQuery) {
            if ($this->selectedDistrict) {
                $districtQuery->where('id', $this->selectedDistrict);
            }
            // Eager load centers and apply search filter to them
            $districtQuery->with(['centers' => function ($centerQuery) {
                if ($this->search) {
                    $centerQuery->where('name', 'like', '%' . Str::lower($this->search) . '%');
                }
            }]);
        }]);

        // Filter regions based on whether they contain any districts that match
        // the selectedDistrict or any centers that match the search term.
        // We use `whereHas` with a count of '>= 0' to include regions/districts
        // even if no matching centers are found within them, so we can display
        // "Aucun établissement" or "Aucun district".
        $regionsQuery->whereHas('districts', function ($districtQuery) {
            if ($this->selectedDistrict) {
                $districtQuery->where('id', $this->selectedDistrict);
            }
            $districtQuery->whereHas('centers', function ($centerQuery) {
                if ($this->search) {
                    $centerQuery->where('name', 'like', '%' . Str::lower($this->search) . '%');
                }
            }, '>=', 0); // Include districts even if their centers are filtered out
        }, '>=', 0); // Include regions even if their districts are filtered out or empty

        // Paginate the results
        $regions = $regionsQuery->paginate(10); // Adjust pagination limit as needed

        // Fetch all regions for the 'Région' dropdown filter (unfiltered)
        $filterRegions = Region::all();

        // Fetch districts for the 'District' dropdown filter based on the currently selected region (unfiltered)
        $filterDistricts = collect(); // Initialize as empty collection
        if ($this->selectedRegion) {
            $filterDistricts = District::where('region_id', $this->selectedRegion)->get();
        }

        return view('livewire.tous.tous-list', [
            'regions' => $regions,
            'filterRegions' => $filterRegions,
            'filterDistricts' => $filterDistricts,
        ]);
    }
}