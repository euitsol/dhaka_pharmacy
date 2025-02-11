<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Collection;

class MedicineTemplateExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return new Collection([]);
    }

    public function headings(): array
    {
        return [
            'name',
            'pro_cat_id',
            'pro_sub_cat_id',
            'generic_id',
            'company_id',
            'strength_id',
            'unit_id',
            'unit_price',
            'price',
            'description',
            'prescription_required',
            'max_quantity',
            'kyc_required',
            'status',
            'has_discount',
            'discount_type', // percentage or fixed
            'discount_value'
        ];
    }
}
