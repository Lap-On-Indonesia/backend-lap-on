<?php

namespace App\Exports;

use App\Models\Report;
use Maatwebsite\Excel\Concerns\FromCollection;

class ReportsExport implements FromCollection
{
    protected $records;

    public function __construct($records)
    {
        $this->records = Report::whereIn('id', $records)->get();
    }

    public function collection()
    {
        return $this->records;
    }
}
