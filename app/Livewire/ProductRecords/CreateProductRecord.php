<?php

namespace App\Livewire\ProductRecords;

use App\Imports\ProductsRecordImport;
use App\Models\Period;
use App\Models\ProductRecord;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;

class CreateProductRecord extends Component
{
    use WithFileUploads;

    public $fileName;

    public $file;

    public function updatedFile()
    {
        $this->fileName = $this->file?->getClientOriginalName() ?? '';
    }

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
        set_time_limit(300);

        // sleep(3);

        $validated = $this->validate($this->rulesImport());

        Excel::import(new ProductsRecordImport(), $this->file->path());

        session()->flash('success', 'Enregistrements effectués avec succès.');

        return $this->redirectRoute('create.product_record');
    }

    public function render()
    {
        return view('livewire.product-records.create-product-record', [
            'period' => Period::latest('period')->first()
        ]);
    }
}
