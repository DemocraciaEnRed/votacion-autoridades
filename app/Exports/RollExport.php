<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class RollExport implements FromCollection, WithMapping, WithHeadings, ShouldAutoSize
{
    protected $rolls;

    public function __construct($rolls)
    {
        $this->rolls = $rolls;
    }

    public function headings(): array
    {
        return [
            'Nombre',
            'Apellido',
            'Documento de identidad',
        ];
    }

    public function collection()
    {
        return $this->rolls;
    }

    public function map($roll): array
    {
        return [
            'name' => $roll->name,
            'last_name' => $roll->last_name,
            'dni' => $roll->dni,
        ];
    }
}
