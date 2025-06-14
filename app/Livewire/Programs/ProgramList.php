<?php

namespace App\Livewire\Programs;

use App\Models\Program;
use Livewire\Component;
use Livewire\WithPagination;

class ProgramList extends Component
{
    use WithPagination;

    public $perPage = 10;
    public $editProgrammeID;
    public $editProgrammeName;
    public $search;

    public function attributes()
    {
        return [
            'editProgrammeName' => 'paramettre de mise a jour.'
        ];
    }

    public function rules()
    {
        return [
            'editProgrammeName' => ['required',' min:3', 'regex:/^[A-Z0-9\-_ ]+$/'],
        ];
    }

    public function messages()
    {
        return [
            'editProgrammeName.required' => 'mise a jour requis',
            'editProgrammeName.min' => 'minimum 03 caracteres',
            'editProgrammeName.regex' => 'Uniquement des majuscules, chiffres, tirets (-) , underscores (_) et espace ( ).',
        ];
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function edit($programmeID)
    {
        $this->editProgrammeID = $programmeID;
        $this->editProgrammeName = Program::find($this->editProgrammeID)->name;
    }

    public function delete($programmeId)
    {
        $programme = Program::findOrFail($programmeId);
        // $this->authorize('delete', $region);
        $programme->delete();

        session()->flash('status', 'Suppression reussie.');
    }

    public function update()
    {
        $this->validate($this->rules());

        Program::find($this->editProgrammeID)->update(
            [
                'name' => $this->editProgrammeName
            ]
        );

        session()->flash('message', 'Mise à jour effectuée avec succès');

        $this->cancelEdit();
    }

    public function cancelEdit()
    {
        $this->reset('editProgrammeID', 'editProgrammeName');
    }

    public function updatedPerPage($value)
    {
        $this->perPage = $value === 'all' ? Program::count() : (int) $value;

        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.programs.program-list', [
            'programmes' => Program::where('name', 'like', '%' . $this->search . '%')->paginate($this->perPage),
            'nbreprogrammes' => Program::all()->count(),
        ]);
    }
}
