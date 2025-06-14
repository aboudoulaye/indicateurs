<?php

namespace App\Livewire\Centers;

use App\Exports\CentersExport;
use App\Models\Center;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class CenterList extends Component
{
    use WithPagination;

    public $perPage =10; 

    public $search;

    public $editCenterName;

    public $editCenterID;

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedPerPage($value)
    {
        $this->perPage = $value === 'all' ? Center::count() : (int) $value;
        $this->resetPage();
    }

    public function delete($centerId)
    {
        $center = Center::findOrFail($centerId);
        // $this->authorize('delete', $region);
        $center->delete();

        session()->flash('status', 'Suppression reussie.');
    }

    public function edit($centerID)
    {
        $this->editCenterID = $centerID;
        $this->editCenterName = Center::find($this->editCenterID)->name;
    }

    public function cancelEdit()
    {
        $this->reset('editCenterID','editCenterName');
    }

    public function attributes()
    {
        return [
            'editCenterName' => 'paramettre de mise a jour.'
        ];
    }

    public function rules()
    {
        return [
            'editCenterName' => ['required',' min:3', 'regex:/^[A-Z0-9\-_ ]+$/'],
        ];
    }

    public function messages()
    {
        return [
            'editCenterName.required' => 'mise a jour requis',
            'editCenterName.min' => 'minimum 03 caracteres',
            'editCenterName.regex' => 'Uniquement des majuscules, chiffres, tirets (-) , underscores (_) et espace ( ).',
        ];
    }

    public function update()
    {
        $this->validate($this->rules());

        Center::find($this->editCenterID)->update(
            [
                'name'=> $this-> editCenterName
            ]
        );

        session()->flash('message', 'Mise à jour effectuée avec succès');

        $this->cancelEdit();
    }

    public function export() 
    {
        return Excel::download(new CentersExport, 'centre_base.xlsx');
    }

    public function render()
    {
        return view('livewire.centers.center-list',[
            'centres' => Center::select('id','code','name','centertype_id')->where('name', 'like', '%' . $this->search . '%')->paginate($this->perPage),
            'nbrecentres' => Center::count(),
        ]);
    }
}
