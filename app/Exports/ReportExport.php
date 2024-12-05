<?php

namespace App\Exports;

use App\Http\Controllers\DashboardController;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ReportExport implements FromView
{
    public function __construct(
        public string $filterBy,
        public array $headers,
        public array $incomes,
        public array $expenses,
        public array $netIncome
    ) {}

    public function view(): View
    {
        return view('exports.report', [
            'filterBy' => $this->filterBy,
            'headers' => $this->headers,
            'incomes' => $this->incomes,
            'expenses' => $this->expenses,
            'netIncome' => $this->netIncome,
        ]);
    }
}
