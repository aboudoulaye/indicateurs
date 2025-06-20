<?php

namespace App\Livewire\ProductPrograms;

use App\Models\ProductProgram;
use Livewire\Component;
use Livewire\WithPagination;

class ProductProgramList extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedPerPage($value)
    {
        $this->perPage = $value === 'all' ? ProductProgram::count() : (int) $value;
        $this->resetPage();
    }

    public function delete($productId, $programId)
    {
        $productProgram = ProductProgram::where('product_id', $productId)
            ->where('program_id', $programId)
            ->firstOrFail();
            
        $productProgram->delete();

        session()->flash('message', 'Suppression reussie.');
    }

    public function render()
    {
        $productPrograms = ProductProgram::with(['program', 'product'])
            ->whereHas('product', function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->orWhereHas('program', function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->paginate($this->perPage);;

        return view('livewire.product-programs.product-program-list', [
            "productPrograms" => $productPrograms,
            "i" => $i = 1,
            "nbr" => ProductProgram::all()->count(),
        ]);
    }
}
