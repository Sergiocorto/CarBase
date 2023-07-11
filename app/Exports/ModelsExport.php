<?php


namespace App\Exports;


use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ModelsExport implements FromCollection, WithHeadings
{
    protected $models;

    public function __construct($models)
    {
        $this->models = $models;
    }

    public function collection()
    {
        return $this->models;
    }

    public function headings(): array
    {
        return [
            'ID',
            'name',
            'make_id'
        ];
    }
}
