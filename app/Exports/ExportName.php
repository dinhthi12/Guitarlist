<?php

namespace App\Exports;

use App\Models\Category;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportName implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        //
        return Category::all();
    }
    public function headings(): array {
        return [
            'ID',
            'Tên ',
            'Ngày tạo',
            'Ngày cập nhật',

        ];
    }

    public function map($cate): array {
        return [
            $cate->id,
            $cate->name,
            $cate->created_at,
            $cate->updated_at
        ];
    }
}
