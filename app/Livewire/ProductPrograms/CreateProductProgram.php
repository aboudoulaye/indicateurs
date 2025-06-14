<?php

namespace App\Livewire\ProductPrograms;

use App\Imports\ProductProgramImport;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;

class CreateProductProgram extends Component
{
    use WithFileUploads;
    
    public $file;

    public $fileName = '';

    // public function attributes()
    // {
    //     return [
    //         'code' => 'code du produit',
    //         'name' => 'produit du produit',
    //         'program_id' => 'id du programme du produit',
    //     ];
    // }

    // public function ManualRules()
    // {
    //     return [
    //         "code" => [
    //             'required',
    //             'digits:7',
    //             'unique:products,code'
    //         ],
    //         "name" => [
    //             'required',
    //             'max:50'
    //         ],
    //         "program_id" => [
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
                'max:2048',
                'mimes:csv,xlsx,xls',
            ],
        ];
    }

    public function messages()
    {
        return [
            // 'code.required'=> 'le code du produit est obligatoire',
            // 'code.digits'=> 'le code du produit est une serie de 7 chiffres',
            // 'code.unique'=> 'le code est deja attribué',

            // 'name.required'=> 'le nom du produit est obligatoire',
            // 'name.max'=> 'le nom ne doit pas depasser 50 caracteres',

            // 'program_id.required'=> 'le nom du programme est obligatoire',

            'file.required' => 'Le fichier est obligatoire ',
            'file.max' => 'La taille maximale du fichier est de 2 Mo.',
            'file.mimes' => 'Le fichier doit être de type : xls ou xlsx uniquement.',
        ];
    }



    // public function save()
    // {
    //     sleep(2);

    //     $validated = $this->validate($this->ManualRules());

    //     Product::Create($validated);

    //     session()->flash('success', 'produit crée avec succès.');


    //     return $this->redirectRoute('create.product');
    // }

    public function updatedFile()
    {
        $this->fileName = $this->file?->getClientOriginalName() ?? '';
    }


    public function import()
    {
        set_time_limit(3000);

        sleep(3);

        $this->validate($this->ImportRules());

        Excel::import(new ProductProgramImport, $this->file->path());

        session()->flash('success', 'Liaisons Programmes/Prouits effectuées avec succès.');

        return $this->redirectRoute('create.product_program');
    }

    public function render()
    {
        return view('livewire.product-programs.create-product-program');
    }
}
