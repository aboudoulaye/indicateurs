<?php

namespace App\Livewire\Records;

use App\Exports\RecordsExport;
use App\Imports\RecordsImport;
use App\Models\Period;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;

class CreateRecord extends Component
{
    use WithFileUploads;
    
    public $file;

    public function attributes()
    {
        return [
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
            'file.required' => 'Le fichier est obligatoire.',
            'file.file' => 'fichier non autorisé.',
            'file.max' => 'La taille maximale du fichier est de 2 Mo.',
            'file.mimes' => 'Le fichier doit être de type : csv, xls ou xlsx uniquement.',
        ];
    }

    public function import()
    {
        sleep(3);

        $validated = $this->validate($this->rulesImport());

        Excel::import(new RecordsImport, $this->file->path());

        session()->flash('success', 'etablissements concernés importés avec succès.');

        return $this->redirectRoute('create.product_record');
    }

    public function export() 
    {
        return Excel::download(new RecordsExport, 'centresconcernés.xlsx');
    }

    public function render()
    {
        return view('livewire.records.create-record',[
            'period'=>Period::latest('period')->first()
        ]);
    }
}
