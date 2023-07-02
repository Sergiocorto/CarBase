<?php


namespace App\Exports;


use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CarsExport implements FromCollection, WithHeadings
{
    protected $cars;

    public function __construct($cars)
    {
        $this->cars = $cars;
    }

    public function collection()
    {
        return $this->cars;
    }

    public function headings(): array
    {
        return [
            'ID',
            'Registration Number',
            'Owner',
            'Color',
            'Make',
            'Model',
            'VIN Code',
            'Year',
        ];
    }
}
