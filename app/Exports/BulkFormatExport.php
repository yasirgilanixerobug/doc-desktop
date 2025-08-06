<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BulkFormatExport implements FromArray, WithHeadings
{
    protected $headingFormat;

    /**
     * @param $headingFormat
     * @param $data
     */
    public function __construct($headingFormat)
    {
        $this->headingFormat = $headingFormat;
    }

    /**
     * @return array
     */
    public function array(): array
    {
        return [];
    }

    /**
     * @return string[]
     */
    public function headings() :array
    {
        return $this->headingFormat;
    }
}
