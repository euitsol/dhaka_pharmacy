<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ReferenceDataExport implements WithMultipleSheets
{
    protected $referenceData;

    public function __construct($referenceData)
    {
        $this->referenceData = $referenceData;
    }

    public function sheets(): array
    {
        $sheets = [];

        foreach ($this->referenceData as $name => $data) {
            $sheets[] = new ReferenceDataSheet($name, $data);
        }

        return $sheets;
    }
}
