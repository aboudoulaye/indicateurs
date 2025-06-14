<?php

namespace App\Livewire\CenterTypes;

use App\Imports\CenterTypeImport;
use App\Models\CenterType;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;

class CreateType extends Component
{
    use WithFileUploads;

    public $fileName = '';

    public $file;

    public $name;

    public function updatedFile()
    {
        $this->fileName = $this->file?->getClientOriginalName() ?? '';
    }

    public function attributes()
    {
        return [
            'name' => 'nom du centre',
            'file' => 'fichier d’importation',
        ];
    }

    public function rulesImport()
    {
        return [
            'file' => [
                'required',
                'file',
                'max:2048',
                'mimes:csv,xlsx,xls',
            ],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Le nom du centre est obligatoire.',
            'name.unique' => 'Le centre existe déjà.',

            'file.required' => 'Le fichier est obligatoire.',
            'file.file' => 'fichier non autorisé.',
            'file.max' => 'La taille maximale du fichier est de 2 Mo.',
            'file.mimes' => 'Le fichier doit être de type : csv, xls ou xlsx uniquement.',
        ];
    }

    public function rulesManual()
    {
        return [
            'name' => [
                'required',
                'unique:center_types,name',
            ]
        ];
    }

    public function import()
    {
        sleep(3);

        $validated = $this->validate($this->rulesImport());

        Excel::import(new CenterTypeImport(), $this->file->path());

        session()->flash('success', 'types de centres importés avec succès.');

        return $this->redirectRoute('type.centres');
    }

    public function save()
    {
        $this->validate($this->rulesManual());

        CenterType::create(
            $this->only(['name'])
        );

        session()->flash('success', 'type de centre crée avec succès.');

        return $this->redirectRoute('type.centres');
    }

    public function render()
    {
        return view('livewire.center-types.create-type');
    }
}
