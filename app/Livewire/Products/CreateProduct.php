<?php

namespace App\Livewire\Products;

use App\Imports\ProductsImport;
use App\Models\Product;
use App\Models\Program;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;

class CreateProduct extends Component
{
    use WithFileUploads;
    
    public $code;

    public $name;

    public $program_id;

    public $file;

    public $fileName;

    public function attributes()
    {
        return [
            'code' => 'code du produit',
            'name' => 'produit du produit',
            'program_id' => 'id du programme du produit',
        ];
    }

    public function ManualRules()
    {
        return [
            "code" => [
                'required',
                'digits:7',
                'unique:products,code'
            ],
            "name" => [
                'required',
                'max:50'
            ],
            "program_id" => [
                'required',
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
            'code.required'=> 'le code du produit est obligatoire',
            'code.digits'=> 'le code du produit est une serie de 7 chiffres',
            'code.unique'=> 'le code est deja attribué',

            'name.required'=> 'le nom du produit est obligatoire',
            'name.max'=> 'le nom ne doit pas depasser 50 caracteres',

            'program_id.required'=> 'le nom du programme est obligatoire',

            'file.required' => 'Le fichier est obligatoire ',
            'file.max' => 'La taille maximale du fichier est de 2 Mo.',
            'file.mimes' => 'Le fichier doit être de type : xls ou xlsx uniquement.',
        ];
    }

    

    public function save()
    {
        sleep(2);

        $validated = $this->validate($this->ManualRules());

        Product::Create($validated);

        session()->flash('success', 'produit crée avec succès.');


        return $this->redirectRoute('create.product');
    }

    public function updatedFile()
    {
        $this->fileName = $this->file?->getClientOriginalName() ?? '';
    }


    public function import()
    {
        set_time_limit(3000);
        
        sleep(3);

        $this->validate($this->ImportRules());

        Excel::import(new ProductsImport, $this->file->path());

        session()->flash('success', 'Programmes importés avec succès.');

        return $this->redirectRoute('create.product');
    }

    #[Layout('components.layouts.app')]
    public function render()
    {
        return view('livewire.products.create-product',[
            'programmes'=> Program::all()
        ]);
    }
}
