<?php

namespace App\Livewire\CenterProducts;

use App\Imports\ProductsCenterImport;
use App\Models\Center;
use App\Models\CenterProduct;
use App\Models\Product;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;

class CreateCenterProduct extends Component
{
    use WithFileUploads;
    
    public $file;

    public $center_id;

    public string $product_id = '';

    public $fileName = '';

    public function attributes()
    {
        return [
            'center_id' => 'id du centre',
            'product_id' => 'id du produit',
            'file' => 'fichier d’importation',
        ];
    }


    // Pour le formulaire manuel
    public function rulesManual()
    {
        return [
            'center_id' => [
                'required',
            ],
            'product_id' => [
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
            'center_id.required' => 'Le nom du centre est obligatoire.',

            'product_id.required' => 'Nom du produit est obligatoire.',

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

        CenterProduct::create($validated);


        session()->flash('success', 'liaison Produits/Etablissements crée avec succès.');

        return $this->redirectRoute('create.product_center');
    }


    public function updatedFile()
    {
        $this->fileName = $this->file?->getClientOriginalName() ?? '';
    }

    public function placeholder()
    {
        return view('placeholder');
    }

    public function import()
    {
        set_time_limit(300);

        $validated = $this->validate($this->rulesImport());

        Excel::import(new ProductsCenterImport, $this->file->path());

        session()->flash('success', 'liste des liaisons produits/Etablissements importée avec succès.');

        return $this->redirectRoute('create.product_center');
    }
    
    #[Layout('components.layouts.app')]
    public function render()
    {
        return view('livewire.center-products.create-center-product',[
            'produits'=> Product::all(),
            'centres'=> Center::all(),
        ]);
    }
}
