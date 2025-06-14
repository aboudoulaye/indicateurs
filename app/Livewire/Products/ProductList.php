<?php

namespace App\Livewire\Products;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;

class ProductList extends Component
{
    use WithPagination;

    public $search;

    public $perPage = 100;

    public $editProductID;

    public $editProductName;

    public function attributes()
    {
        return [
            'editProductName' => 'paramettre de mise a jour.'
        ];
    }

    public function rules()
    {
        return [
            'editProductName' => ['required',' min:3', 'regex:/^[A-Z0-9\-_ ]+$/'],
        ];
    }

    public function messages()
    {
        return [
            'editProductName.required' => 'mise a jour requis',
            'editProductName.min' => 'minimum 03 caracteres',
            'editProductName.regex' => 'Uniquement des majuscules, chiffres, tirets (-) , underscores (_) et espace ( ).',
        ];
    }

    public function updatedPerPage($value)
    {
        $this->perPage = $value === 'all' ? Product::count() : (int) $value;

        $this->resetPage();
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function update()
    {
        $this->validate($this->rules());

        Product::find($this->editProductID)->update(
            [
                'name' => $this->editProductName
            ]
        );

        session()->flash('message', 'Mise à jour effectuée avec succès');

        $this->cancelEdit();
    }

    public function cancelEdit()
    {
        $this->reset('editProductID', 'editProductName');
    }

    public function delete($productId)
    {
        Product::where('product_id', $productId)
            ->delete();

        session()->flash('status', 'Suppression reussie.');
    }

    public function edit($productID)
    {
        $this->editProductID = $productID;
        $this->editProductName = Product::find($this->editProductID)->name;
    }

    public function render()
    {
        return view('livewire.products.product-list', [
            'products' => Product::where('name', 'like', '%' . $this->search . '%')->paginate($this->perPage),
            'nbre' => Product::all()->count()
        ]);
    }
}
