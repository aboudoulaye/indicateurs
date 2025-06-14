<?php

namespace App\Livewire\ProductRecords;

use App\Exports\ProductsREcordExport;
use App\Models\Period;
use App\Models\ProductRecord;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class ProductRecordsList extends Component
{
    use WithPagination;

    public $data;

    public $search;

    public $perPage=20;

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedPerPage($value)
    {
        $this->perPage = $value === 'all' ? ProductRecord::count() : (int) $value;
        $this->resetPage();
    }

    public function export() 
    {
        return Excel::download(new ProductsREcordExport, 'products.xlsx');
    }


    public function render()
    {
        return view('livewire.product-records.product-records-list',[
            'productRecords'=>ProductRecord::with(['product', 'record.center', 'record.period'])
                                ->whereHas('record.center', function ($query) {
                                    $query->where('name', 'like', '%' . $this->search . '%');
                                })->paginate($this->perPage),
            'period'=>Period::latest()->first()
        ]);
    }
}
