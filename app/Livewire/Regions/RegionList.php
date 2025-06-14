<?php

namespace App\Livewire\Regions;

use App\Exports\RegionsExport;
use App\Models\District;
use App\Models\Region;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class RegionList extends Component
{
    use WithPagination;

    public $perPage = 5;

    public $search = '';

    public $editRegionID;

    #[Rule('required|min:3')]
    public $editRegionName = '';

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedPerPage($value)
    {
        $this->perPage = $value === 'all' ? Region::count() : (int) $value;
        $this->resetPage();
    }

    public function delete($regionId)
    {
        $region = Region::findOrFail($regionId);
        // $this->authorize('delete', $region);
        $region->delete();

        session()->flash('status', 'Suppression reussie.');
    }

    public function edit($regionID)
    {
        $this->editRegionID = $regionID;
        $this->editRegionName = Region::find($this->editRegionID)->name;
    }

    public function cancelEdit()
    {
        $this->reset('editRegionID','editRegionName');
    }

    public function attributes()
    {
        return [
            'editRegionName' => 'paramettre de mise a jour.'
        ];
    }

    public function rules()
    {
        return [
            'editRegionName' => ['required',' min:3', 'regex:/^[A-Z0-9\-_ ]+$/'],
        ];
    }

    public function messages()
    {
        return [
            'editRegionName.required' => 'mise a jour requis',
            'editRegionName.min' => 'minimum 03 caracteres',
            'editRegionName.regex' => 'Uniquement des majuscules, chiffres, tirets (-) , underscores (_) et espace ( ).',
        ];
    }

    public function update()
    {
        $this->validate($this->rules());

        Region::find($this->editRegionID)->update(
            [
                'name'=> $this-> editRegionName
            ]
        );

        session()->flash('message', 'Mise à jour effectuée avec succès');

        $this->cancelEdit();
    }

    public function export() 
    {
        return Excel::download(new RegionsExport, 'Regions.xlsx');
    }

    public function render()
    {
        return view('livewire.regions.region-list', [
            'regions' => Region::with('districts.centers')->where('name', 'like', '%' . $this->search . '%')->paginate($this->perPage),
            'nbreregions' => Region::count(),
        ]);
    }
}
