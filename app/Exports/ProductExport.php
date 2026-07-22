<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProductExport implements FromCollection, WithHeadings
{
    public function __construct(private $products){}

    public function collection()
    {
        return collect($this->products);
    }

    public function headings(): array
    {
        return ['Name', 'Category', 'Brand', 'Price'];
    }
}
