<?php


namespace App\Livewire\CenterProgams;

use App\Imports\ProgramsCenterImport;
use App\Models\Center;
use App\Models\CenterProgram;
use App\Models\Program;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;

class CreateCenterProgram extends Component
{
    use WithFileUploads;

    public $center_id;

    public $program_id;

    public $file;

    public $fileName;

    // public function ManulRules()
    // {
    //     return [
    //         'center_id' => [
    //             'required',
    //         ],
    //         'program_id' => [
    //             'required',
    //         ],
    //     ];
    // }

    public function ImportRules()
    {
        return [
            'file' => [
                'required',
                'file',
                'max:5048',
                'mimes:csv,xlsx,xls',
            ],
        ];
    }

    public function attributes()
    {
        return [
            'center_id' => 'id du centre',
            'program_id' => 'id du programme',
        ];
    }

    public function messages()
    {
        return [
            'center_id.required' => 'le nom de center est obligatoire.',
            'program_id.required' => 'le nom du programme est obligatoire.',

            'file.required' => 'Le fichier est obligatoire.',
            'file.file' => 'fichier non autorisé.',
            'file.max' => 'La taille maximale du fichier est de 5 Mo.',
            'file.mimes' => 'Le fichier doit être de type : csv, xls ou xlsx uniquement.',
        ];
    }

    public function save()
    {
        sleep(2);

        $validated = $this->validate($this->ManulRules());

        CenterProgram::Create($validated);

        session()->flash('success', 'liaison etablissement/programme effectuée avec succès.');

        return $this->redirectRoute('create.program_center');
    }

    public function updatedFile()
    {
        $this->fileName = $this->file?->getClientOriginalName() ?? '';
    }
    
    public function import()
    {
        set_time_limit(3000);

        // sleep(3);

        $validated = $this->validate($this->ImportRules());

        Excel::import(new ProgramsCenterImport, $this->file->path());

        session()->flash('success', 'liaisons etablissements/programmes effectuées avec succès.');

        return $this->redirectRoute('create.program_center');
    }

    #[Layout('components.layouts.app')]
    public function render()
    {
        return view('livewire.center-progams.create-center-program', [
            'programmes' => Program::all(),
            'centres' => Center::all()
        ]);
    }
}
