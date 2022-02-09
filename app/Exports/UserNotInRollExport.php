<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class UserNotInRollExport implements FromCollection, WithMapping, WithHeadings, ShouldAutoSize
{
    protected $usersNotInRoll;

    public function __construct($usersNotInRoll)
    {
        $this->usersNotInRoll = $usersNotInRoll;
    }

    public function headings(): array
    {
        return [
            'Email',
        ];
    }

    public function collection()
    {
        return $this->usersNotInRoll;
    }

    public function map($userNotInRoll): array
    {
        return [
            'email' => $userNotInRoll->email,
        ];
    }
}
