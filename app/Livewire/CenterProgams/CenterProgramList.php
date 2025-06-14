<?php

namespace App\Livewire\CenterProgams;

use App\Models\CenterProgram;
use Livewire\Component;
use Livewire\WithPagination;

class CenterProgramList extends Component
{
    use WithPagination;

    public $search;

    public $perPage = 10;

    public function updatedPerPage($value)
    {
        $this->perPage = $value === 'all' ? CenterProgram::count() : (int) $value;

        $this->resetPage();
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function delete($centerId, $programId)
    {
        CenterProgram::where('center_id', $centerId)
            ->where('program_id', $programId)
            ->delete();

        session()->flash('status', 'Suppression reussie.');
    }

    public function render()
    {
        return view('livewire.center-progams.center-program-list', [
            'centerprogrammes' => CenterProgram::with(['center', 'program'])->whereHas('center', function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->OrwhereHas('program', function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->paginate($this->perPage),
            'i' => $i = 1
        ]);
    }
}
