<?php

namespace App\Imports;

use App\Models\Roll;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class RollImport implements ToCollection
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        foreach($collection as $row) {

            Roll::create([
                'name' => $row[0],
                'last_name' => $row[1],
                'dni' => $row[2],
            ]);
        }
    }

    public function startRow(): int
    {
        return 2;
    }
}
