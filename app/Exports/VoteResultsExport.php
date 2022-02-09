<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class VoteResultsExport implements FromCollection, WithMapping, WithHeadings, ShouldAutoSize, WithColumnFormatting, WithStrictNullComparison
{
    protected $blocks;

    public function __construct($blocks)
    {
        $this->blocks = $blocks;
    }

    public function headings(): array
    {
        return [
            'Bloque',
            'Plancha',
            'Votos',
        ];
    }

    public function collection()
    {
        return $this->blocks;
    }

    public function map($block): array
    {
        $return = [];

        foreach($block->votes as $voteResult) {
            $return[] = [
                $block->name,
                $voteResult->plate->name,
                $voteResult->votes,
            ];
        }

        $return[] = [
            $block->name,
            'Votos en blanco',
            $block->votes_blank->votes,
        ];

        return $return;
    }

    public function columnFormats(): array
    {
        return [
            'C' => NumberFormat::FORMAT_NUMBER,
        ];
    }
}
