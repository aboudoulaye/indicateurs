<?php

namespace App\Livewire\CenterTypes;

use App\Models\CenterType;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class TypeList extends Component
{
    use WithPagination;

    public $perPage =5; 

    public $search;

    public $editTypeName;

    public $editTypeID;

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedPerPage($value)
    {
        $this->perPage = $value === 'all' ? CenterType::count() : (int) $value;
        $this->resetPage();
    }

    public function delete($typeId)
    {
        $center = CenterType::findOrFail($typeId);
        
        $center->delete();

        session()->flash('status', 'Suppression reussie.');
    }

    public function edit($TypeID)
    {
        $this->editTypeID = $TypeID;
        $this->editTypeName = CenterType::find($this->editTypeID)->name;
    }

    public function cancelEdit()
    {
        $this->reset('editTypeID','editTypeName');
    }

    public function attributes()
    {
        return [
            'editTypeName' => 'paramettre de mise a jour.'
        ];
    }

    public function rules()
    {
        return [
            'editTypeName' => ['required', 'min:3', 'regex:/^[A-Z0-9\-_.\/ ]+$/'],
        ];
    }

    public function messages()
    {
        return [
            'editTypeName.required' => 'mise a jour requis',
            'editTypeName.min' => 'minimum 03 caracteres',
            'editTypeName.regex' => 'Uniquement des majuscules, chiffres, tirets (-) , underscores (_), slash (/), point (.) et espace ( ).',
        ];
    }

    public function update()
    {
        $this->validate($this->rules());

        CenterType::find($this->editTypeID)->update(
            [
                'name'=> $this-> editTypeName
            ]
        );

        session()->flash('message', 'Mise à jour effectuée avec succès');

        $this->cancelEdit();
    }

    // public function export() 
    // {
    //     return Excel::download(new CentersExport, 'centre_base.xlsx');
    // }

    public function render()
    {
        return view('livewire.center-types.type-list',[
            'types' => CenterType::select('id','name')->where('name', 'like', '%' . $this->search . '%')->paginate($this->perPage),
            'nbretypes' => CenterType::count(),
        ]);
    }
}
