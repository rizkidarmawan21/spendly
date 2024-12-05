<?php

namespace App\Http\Controllers;

use App\Exports\ReportExport;
use App\Models\AccountCategory;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->input('filter', 'week');

        if ($filter !== 'week' && $filter !== 'month' && $filter !== 'year') {
            $filter = 'week';
        }

        $headers = $this->getHeaderTable($filter);
        $incomes = $this->getData($filter, 'credit');
        $expenses = $this->getData($filter, 'debit');
        $netIncome = $this->getNeIncome($incomes, $expenses);
        return view('dashboard', [
            'headers' => $headers,
            'incomes' => $incomes,
            'expenses' => $expenses,
            'netIncome' => $netIncome,
        ]);
    }

    public function exportExcel(Request $request)
    {
        $filter = $request->input('filter', 'week');

        if ($filter !== 'week' && $filter !== 'month' && $filter !== 'year') {
            $filter = 'week';
        }

        $headers = $this->getHeaderTable($filter);
        $incomes = $this->getData($filter, 'credit');
        $expenses = $this->getData($filter, 'debit');
        $netIncome = $this->getNeIncome($incomes, $expenses);

        return Excel::download(new ReportExport($filter, $headers, $incomes, $expenses, $netIncome), 'report.xlsx');
    }

    private function getData($filter, $type)
    {
        $categories = AccountCategory::with(['account', 'account.transactions'])->where('type', $type)->get();
        $today = now();

        $wording = $type === 'credit' ? 'Total Income' : 'Total Expense';

        switch ($filter) {
            case 'week':
                $startDate = $today->startOfWeek()->format('Y-m-d');
                $endDate = $today->endOfWeek()->format('Y-m-d');

                $reports = [];

                foreach ($categories as $category) {
                    for ($date = $startDate; $date <= $endDate; $date++) {
                        $total = 0;
                        if ($category->account && $category->account->count() > 0) {
                            foreach ($category->account as $account) {
                                $total += $account->transactions()
                                    ->where('date', $date)
                                    ->sum('amount');

                                $reports[$category->name]['data'][$date] = $total;
                            }
                        }

                        $reports[$category->name]['data'][$date] = $total;
                        $reports[$category->name]['type'] = $type;
                    }
                }


                foreach ($reports as $key => $value) {
                    if ($key !== $wording) {
                        foreach ($value['data'] as $date => $amount) {
                            if (!isset($reports[$wording]['data'][$date])) {
                                $reports[$wording]['data'][$date] = 0;
                                $reports[$wording]['type'] = "total_$type";
                            }
                            $reports[$wording]['data'][$date] += $amount;
                            $reports[$wording]['type'] = "total_$type";
                        }
                    }
                }

                return $reports;
                break;
            case 'month':
                $startDate = $today->startOfMonth()->format('Y-m-d');
                $endDate = $today->endOfMonth()->format('Y-m-d');

                $reports = [];

                foreach ($categories as $category) {
                    for ($date = $startDate; $date <= $endDate; $date++) {
                        $total = 0;
                        if ($category->account && $category->account->count() > 0) {
                            foreach ($category->account as $account) {
                                $total += $account->transactions()
                                    ->where('date', $date)
                                    ->sum('amount');

                                $reports[$category->name]['data'][$date] = $total;
                            }
                        }

                        $reports[$category->name]['data'][$date] = $total;
                        $reports[$category->name]['type'] = $type;
                    }
                }


                foreach ($reports as $key => $value) {
                    if ($key !== $wording) {
                        foreach ($value['data'] as $date => $amount) {
                            if (!isset($reports[$wording]['data'][$date])) {
                                $reports[$wording]['data'][$date] = 0;
                                $reports[$wording]['type'] = "total_$type";
                            }
                            $reports[$wording]['data'][$date] += $amount;
                            $reports[$wording]['type'] = "total_$type";
                        }
                    }
                }


                return $reports;
                break;
            case 'year':

                $reports = [];
                foreach ($categories as $category) {
                    for ($month = 1; $month <= 12; $month++) {
                        $total = 0;
                        if ($category->account && $category->account->count() > 0) {
                            foreach ($category->account as $account) {
                                $total += $account->transactions()
                                    ->whereMonth('date', $month)
                                    ->sum('amount');

                                $reports[$category->name]['data'][$today->format('Y') . '-' . $month] = $total;
                            }
                        }
                        $reports[$category->name]['data'][$today->format('Y') . '-' . $month] = $total;
                        $reports[$category->name]['type'] = $type;
                    }
                }

                foreach ($reports as $key => $value) {
                    if ($key !== $wording) {
                        foreach ($value['data'] as $month => $amount) {
                            if (!isset($reports[$wording]['data'][$month])) {
                                $reports[$wording]['data'][$month] = 0;
                                $reports[$wording]['type'] = "total_$type";
                            }
                            $reports[$wording]['data'][$month] += $amount;
                            $reports[$wording]['type'] = "total_$type";
                        }
                    }
                }

                return $reports;
                break;
            default:
                # code...
                break;
        }
    }

    private function getNeIncome($incomes, $expenses)
    {
        $latestIncome = end($incomes);
        $latestExpense = end($expenses);

        // merge array latest income and latest expense
        $data['Net Income'] = [
            'data' => [],
            'type' => 'net_income'
        ];

        foreach ($latestIncome['data'] as $date => $amount) {
            $data['Net Income']['data'][$date] = $amount - $latestExpense['data'][$date];
        }

        return $data;
    }

    private function getHeaderTable($filter)
    {
        $today = now();
        switch ($filter) {
            case 'week':

                $startDay = (int) $today->startOfWeek()->format('d');
                $endDay = (int) $today->endOfWeek()->format('d');

                for ($i = $startDay; $i <= $endDay; $i++) {
                    // add full date
                    $dates[] = Carbon::createFromDate($today->year, $today->month, $i)->format('Y-m-d');
                }

                return $dates;
                break;
            case 'month':
                // get this month
                $startDay = (int) $today->startOfMonth()->format('d');
                $endDay = (int) $today->endOfMonth()->format('d');

                for ($i = $startDay; $i <= $endDay; $i++) {
                    // add full date
                    $dates[] = Carbon::createFromDate($today->year, $today->month, $i)->format('Y-m-d');
                }

                return $dates;
                break;
            case 'year':
                // get this year
                $startMonth = (int) $today->startOfYear()->format('m');
                $endMonth = (int) $today->endOfYear()->format('m');

                $dates = [];
                for ($i = $startMonth; $i <= $endMonth; $i++) {
                    // add full date
                    $dates[] = Carbon::createFromDate($today->year, $i, 1)->format('Y-m');
                }

                return $dates;
                break;

            default:
                # week
                $startDay = (int) $today->startOfWeek()->format('d');
                $endDay = (int) $today->endOfWeek()->format('d');

                for ($i = $startDay; $i <= $endDay; $i++) {
                    // add full date
                    $dates[] = Carbon::createFromDate($today->year, $today->month, $i)->format('Y-m-d');
                }

                return $dates;
                break;
        }
    }
}
