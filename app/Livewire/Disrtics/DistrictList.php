<?php

namespace App\Livewire\Disrtics;

use App\Models\District;
use Livewire\Component;
use Livewire\WithPagination;

class DistrictList extends Component
{
    use WithPagination;

    public $perPage =10 ; 

    public $search;

    public $editDistrictName;

    public $editDistrictID;

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedPerPage($value)
    {
        $this->perPage = $value === 'all' ? District::count() : (int) $value;
        $this->resetPage();
    }

    public function delete($districtId)
    {
        $district = District::findOrFail($districtId);
        // $this->authorize('delete', $region);
        $district->delete();

        session()->flash('status', 'Suppression reussie.');
    }

    public function edit($districtID)
    {
        $this->editDistrictID = $districtID;
        $this->editDistrictName = District::find($this->editDistrictID)->name;
    }

    public function cancelEdit()
    {
        $this->reset('editDistrictID','editDistrictName');
    }

    public function attributes()
    {
        return [
            'editDistrictName' => 'paramettre de mise a jour.'
        ];
    }

    public function rules()
    {
        return [
            'editDistrictName' => ['required',' min:3', 'regex:/^[A-Z0-9\-_ ]+$/'],
        ];
    }

    public function messages()
    {
        return [
            'editDistrictName.required' => 'mise a jour requis',
            'editDistrictName.min' => 'minimum 03 caracteres',
            'editDistrictName.regex' => 'Uniquement des majuscules, chiffres, tirets (-) , underscores (_) et espace ( ).',
        ];
    }

    public function update()
    {
        $this->validate($this->rules());

        District::find($this->editDistrictID)->update(
            [
                'name'=> $this-> editDistrictName
            ]
        );

        session()->flash('message', 'Mise à jour effectuée avec succès');

        $this->cancelEdit();
    }


    public function render()
    {
        return view('livewire.disrtics.district-list',[
            'districts'=> District::with('centers')->where('name', 'like', '%' . $this->search . '%')->paginate($this->perPage),
            'nbredistricts' => District::all()->count()
        ]);
    }
}
