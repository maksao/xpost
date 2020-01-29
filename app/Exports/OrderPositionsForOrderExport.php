<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class OrderPositionsForOrderExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    use Exportable;

    protected $positions;

    public function __construct($positions)
    {
        $this->positions = $positions;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->positions;
    }

    public function map($position) : array
    {
        return [
            $position->order->number,
            $position->order->created_at->format('m.d.Y'),
            $position->brand_name,
            $position->article,
            $position->comment,
            $position->name_eng,
            $position->quantity,
        ];
    }

    public function headings(): array
    {
        return [
            '№ ORDER',
            'DATE',
            'MAKE',
            'OEM',
            'REFERENCE',
            'DISCRIPTIONS',
            '_Q-TY_',
        ];
    }
}
