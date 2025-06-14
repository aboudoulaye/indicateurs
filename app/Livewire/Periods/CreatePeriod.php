<?php

namespace App\Livewire\Periods;

use App\Models\Period;
use Livewire\Component;

class CreatePeriod extends Component
{
    public $period;

    public function attributes()
    {
        return  ['period'=>'periode d\'enregistrement'];
    }

    public function rules()
    {
        return [
            'period'=>[
                'required'
            ]
            ];
    }

    public function messages()
    {
        return [
            'period.required'=>'la date est requise.'
        ];
    }

    public function save()
    {
        $validated = $this->validate($this->rules());

        Period::Create($validated);

        session()->flash('success', 'period crée avec succès.');

        return $this -> redirectRoute('create.record');


    }

    public function render()
    {
        return view('livewire.periods.create-period');
    }
}
