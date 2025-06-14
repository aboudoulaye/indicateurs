<?php

namespace App\Exports;

use App\Models\Record;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class RecordsExport implements FromCollection, WithMapping, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Record::with(['center', 'period'])->get();
    }

    public function map($record): array
    {
        return [
            $record->id,
            $record->center->name ?? 'N/A',
            $record->period->period ?? 'N/A',
        ];
    }

    /**
     * Entêtes du fichier Excel
     */
    public function headings(): array
    {
        return [
            'ID',
            'Nom du centre',
            'Nom de la période',
        ];
    }
}
