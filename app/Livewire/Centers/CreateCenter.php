<?php

namespace App\Livewire\Centers;

use App\Exports\CentersExport;
use App\Imports\CentersImport;
use App\Models\Center;
use App\Models\CenterType;
use App\Models\District;
use App\Models\Region;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;

class CreateCenter extends Component
{
    use WithFileUploads;

    public $regionID;

    public $fileName = '';

    public $file;

    #[Rule('required')]
    public $district_id;

    #[Rule('required')]
    public $name;

    #[Rule('required')]
    public $code;

    #[Rule('required')]
    public $centertype_id;

    public function attributes()
    {
        return [
            'name' => 'nom du centre',
            'file' => 'fichier d’importation',
            'district_id' => 'id de la region du district',
            'code' => 'code du centre',
            'centertype_id' => 'id du type de centre'
        ];
    }

    // Pour le formulaire manuel
    public function rulesManual() // Or just 'rules()' if it's your primary validation
    {
        return [
            'name' => [
                'required',
                'unique:centers,name,' 

            ],
            'district_id' => [
                'required',
                'exists:districts,id', // Add exists rule for foreign keys
            ],
            'centertype_id' => [
                'required',
                'exists:center_types,id', // Assuming your table is 'center_types'
            ],
            'code' => [
                'required',
                'digits:8',
                'unique:centers,code,' . (isset($this->centerId) ? $this->centerId : 'NULL') . ',id', // Add ignore for update scenario
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
            'name.required' => 'Le nom du centre est obligatoire.',
            'name.unique' => 'Le centre existe déjà.',

            'district_id.required' => 'Le nom du district est obligatoire.',
            'centetype_id.required' => 'Le nom du type est obligatoire.',

            'code.required' => 'Le code du centre est obligatoire.',
            'code.digits' => 'minimum 8 chiffres.',
            'code.unique' => 'le code deja attribué à un autre site.',

            'file.required' => 'Le fichier est obligatoire.',
            'file.file' => 'fichier non autorisé.',
            'file.max' => 'La taille maximale du fichier est de 2 Mo.',
            'file.mimes' => 'Le fichier doit être de type : csv, xls ou xlsx uniquement.',
        ];
    }

    #[Computed()]
    public function regions()
    {
        return Region::all();
    }

    #[Computed()]
    public function districts()
    {
        return District::where('region_id', $this->regionID)->get();
    }

    #[Computed()]
    public function types()
    {
        return CenterType::select('id','name')->get();
    }

    public function updatedRegionID()
    {
        return $this->district_id = null;
    }

    public function save()
    {
        $this->validate($this->rulesManual());

        Center::create(
            $this->only(['district_id', 'name', 'code', 'centertype_id'])
        );

        session()->flash('success', 'centre crée avec succès.');

        return $this->redirectRoute('create.centres');
    }

    public function updatedFile()
    {
        $this->fileName = $this->file?->getClientOriginalName() ?? '';
    }

    public function import()
    {
        sleep(3);

        $validated = $this->validate($this->rulesImport());

        Excel::import(new CentersImport, $this->file->path());

        session()->flash('success', 'centres importés avec succès.');

        return $this->redirectRoute('create.centres');
    }

    #[Layout('components.layouts.app')]
    public function render()
    {
        return view('livewire.centers.create-center');
    }
}
