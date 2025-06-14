<?php

namespace App\Livewire\Disrtics;

use App\Imports\DistrictsImport;
use App\Models\District;
use App\Models\Region;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;

class CreateDistrict extends Component
{
    use WithFileUploads;

    #[Rule('required')]
    public $file;

    public $region_id;

    public $fileName = '';


    public string $name = '';

    public function attributes()
    {
        return [
            'name' => 'nom du district',
            'file' => 'fichier d’importation',
            'region_id' => 'id de la region du district'
        ];
    }


    // Pour le formulaire manuel
    public function rulesManual()
    {
        return [
            'name' => [
                'required',
                'unique:districts,name',
            ],
            'region_id' => [
                'required',
            ],
        ];
    }

    // Pour le formulaire d'import
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
            'name.required' => 'Le nom du district est obligatoire.',
            'name.unique' => 'Le district existe déjà.',

            'region_id.required' => 'La région est obligatoire.',

            'file.required' => 'Le fichier est obligatoire.',
            'file.file' => 'fichier non autorisé.',
            'file.max' => 'La taille maximale du fichier est de 2 Mo.',
            'file.mimes' => 'Le fichier doit être de type : csv, xls ou xlsx uniquement.',
        ];
    }




    public function save()
    {
        sleep(2);

        $validated = $this->validate($this->rulesManual());

        District::create([
            'name' => $validated['name'],
            'region_id' => $validated['region_id'],
        ]);


        session()->flash('success', 'District crée avec succès.');

        return $this->redirectRoute('create.districts');
    }


    public function updatedFile()
    {
        $this->fileName = $this->file?->getClientOriginalName() ?? '';
    }


    public function import()
    {
        sleep(3);

        $validated = $this->validate($this->rulesImport());

        Excel::import(new DistrictsImport, $this->file->path());

        session()->flash('success', 'Districts importées avec succès.');

        return $this->redirectRoute('create.districts');
    }

    #[Layout('components.layouts.app')]
    public function render()
    {
        return view('livewire.disrtics.create-district', [

            'regions' => Region::all(),
        ]);
    }
}
