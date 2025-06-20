<?php

namespace App\Livewire\ProductSpecials;

use App\Models\Product;
use App\Models\ProductSpecial;
use App\Models\Special;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Component;

class CreateProductSpecial extends Component
{
    public $special_id;

    public $product_id;

    public function attributes()
    {
        return [
            'special_id' => 'id du programme special.',
            'product_id' => 'id du produit concerné.',
        ];
    }

    public function rules()
    {
        return [
            'special_id' => 'required',
            'product_id' => 'required|unique:product_specials',
        ];
    }

    public function messages()
    {
        return [
            'special_id.required' => 'nom de programe requis',
            'product_id.required' => 'nom du produit est requis.',
            'product_id.unique' => 'ce produit est deja lié à ce programme special.',
        ];
    }

    public function save()
    {
        sleep(2); 

        $validated = $this->validate($this->rules());

        ProductSpecial::Create($validated);

        session()->flash('success', 'Liaison produit/special effectuée avec succès.');

        return $this->redirectRoute('create.special_product');
    }

    #[Computed()]
    public function Specials()
    {
        return Special::select('id', 'name')->get();
    }

    #[Computed()]
    public function produits()
    {
        return Product::select('id', 'name','code')->get();
    }

    #[Layout('components.layouts.app')]
    public function render()
    {
        return view('livewire.product-specials.create-product-special');
    }
}
