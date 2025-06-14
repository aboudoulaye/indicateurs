<?php

namespace App\Livewire\Programs;

use App\Imports\ProgramsImport;
use App\Models\Program;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;

class CreateProgram extends Component
{

    use WithFileUploads; 

    public $file;

    public $fileName = '';


    public string $name = '';

    public string $code = '';

    public function attributes()
    {
        return [
            'name' => 'nom du programme',
            'code' => 'code du programme',
            // 'file' => 'fichier d’importation',
        ];
    }


    public function ManualRules()
    {
        return [
            'name' => [
                'required',
                'unique:programs,name',
            ],
            'code' => [
                'required',
                'unique:programs,code',
            ],
        ];
    }

    public function ImportRules()
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
            'name.required' => 'Le nom du programme obligatoire.',
            'name.unique' => 'Le nom du programme existe déjà.',

            'code.required' => 'Le code du programme obligatoire.',
            'code.unique' => 'Le code du programme existe déjà.',

            'file.required' => 'Le fichier est obligatoire ',
            'file.max' => 'La taille maximale du fichier est de 2 Mo.',
            'file.mimes' => 'Le fichier doit être de type : xls ou xlsx uniquement.',
        ];
    }
    public function save()
    {
        sleep(2);

        $validated = $this->validate($this->ManualRules());

        Program::create(
            $validated
        );

        session()->flash('success', 'programme crée avec succès.');

        return $this->redirectRoute('create.programs');
    }

    public function updatedFile()
    {
        $this->fileName = $this->file?->getClientOriginalName() ?? '';
    }


    public function import()
    {
        sleep(3);

        $this->validate($this->ImportRules());

        Excel::import(new ProgramsImport, $this->file->path());

        session()->flash('success', 'Programmes importés avec succès.');

        return $this->redirectRoute('create.programs');
    }

    #[Layout('components.layouts.app')]
    public function render()
    {
        return view('livewire.programs.create-program');
    }
}
