<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class UserExport implements FromCollection, WithMapping, WithHeadings, ShouldAutoSize
{
    protected $users;

    public function __construct($users)
    {
        $this->users = $users;
    }

    public function headings(): array
    {
        return [
            'Nombre',
            'DNI',
            'Email',
            '¿Votó?',
        ];
    }

    public function collection()
    {
        return $this->users;
    }

    public function map($user): array
    {
        return [
            $user->name.' '.$user->last_name,
            $user->dni,
            $user->email,
            ($user->vote) ? "Sí" : "No",
        ];
    }
}
