<?php

namespace App\Livewire\Specilas;

use App\Models\Product;
use App\Models\Special;
use Livewire\Attributes\Layout;
use Livewire\Component;

class CreateSpecial extends Component
{

    public $name;

    public function attributes()
    {
        return [
            'name'=>'nom du programme special',
        ];
    }

    public function rules()
    {
        return [
            'name' => 'required|min:4',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'nom de programe requis',
            'name.min' => 'minimum 4 carateres.',
        ];
    }

    public function save()
    {
        $validated = $this->validate($this->rules());

        Special::Create($validated);

        session()->flash('success', 'Programme special créé avec succès.');

        return $this->redirectRoute('create.special');

    }

    #[Layout('components.layouts.app')]
    public function render()
    {
        return view('livewire.specilas.create-special',[
            'produits'=>Product::all()
        ]);
    }
}
