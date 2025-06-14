<?php

namespace App\Exports;

use App\Models\Center;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class CentersExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Center::with(['district','centertype'])->get();
    }

    public function map($center): array
    {
        return [
            $center->id,
            $center->code,
            $center->district->name,
            $center->centertype->name,
            $center->name,
        ];
    }

    public function headings(): array
    {
        return [
            'ID',
            'code',
            'Nom district',
            'Type',
            'Etablissement',
        ];
    }
}
