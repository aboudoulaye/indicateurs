<?php

namespace App\Livewire\Regions;

use App\Imports\RegionsImport;
use App\Models\Region;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;

class CreateRegion extends Component
{
    use WithFileUploads;

    #[Rule('required')]
    public $file;

    public $fileName = '';


    public string $name = '';

    public function attributes()
    {
        return [
            'name' => 'nom de la région',
            'file' => 'fichier d’importation',
        ];
    }


    public function rules()
    {
        return [
            'name' => [
                'nullable',
                'required_without:file',
                'unique:regions,name',
            ],
            'file' => [
                'nullable',
                'required_without:name',
                'file',
                'max:2048',
                'mimes:csv,xlsx,xls',
            ],
        ];
    }

    public function messages()
    {
        return [
            'name.required_without' => 'Le nom de la région est obligatoire.',
            'name.unique' => 'Le nom de la région existe déjà.',

            'file.required' => 'Le fichier est obligatoire ',
            'file.max' => 'La taille maximale du fichier est de 2 Mo.',
            'file.mimes' => 'Le fichier doit être de type : xls ou xlsx uniquement.',
        ];
    }



    public function save()
    {
        sleep(2);

        $this->validateOnly('name');

        Region::create(
            $this->only(['name'])
        );

        session()->flash('success', 'Région créée avec succès.');

        return $this->redirectRoute('create.regions');
    }


    public function updatedFile()
    {
        $this->fileName = $this->file?->getClientOriginalName() ?? '';
    }


    public function import()
    {
        sleep(3);

        $this->validateOnly('file');

        Excel::import(new RegionsImport, $this->file->path());

        session()->flash('success', 'Régions importées avec succès.');

        return $this->redirectRoute('create.regions');
    }


    #[Layout('components.layouts.app')]
    public function render()
    {
        return view('livewire.regions.create-region');
    }
}
