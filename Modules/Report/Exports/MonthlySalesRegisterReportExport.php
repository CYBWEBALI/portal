<?php

namespace Modules\Report\Exports;

use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class MonthlySalesRegisterReportExport implements FromCollection, WithHeadings, ShouldAutoSize, WithTitle
{
    protected $invoices;

    public function __construct($invoices)
    {
        $this->invoices = $invoices;
    }

    public function collection()
    {
        return $this->invoices;
    }

    public function headings(): array
    {
        if (is_array($this->invoices->first())) {
            return array_keys($this->invoices->first());
        }

        return [];
    }

    public function title(): string
    {
        return 'Monthly Sales Register Report';
    }
}
