<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ReferenceDataSheet implements FromCollection, WithTitle, WithHeadings
{
    protected $name;
    protected $data;

    public function __construct($name, $data)
    {
        $this->name = $name;
        $this->data = $data;
    }

    public function collection()
    {
        return $this->data;
    }

    public function title(): string
    {
        return ucfirst(str_replace('_', ' ', $this->name));
    }

    public function headings(): array
    {
        return array_keys($this->data->first()->toArray());
    }
}
