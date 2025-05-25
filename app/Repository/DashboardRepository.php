<?php

namespace App\Repository;

use App\Models\MonthlyFee;
use App\Models\Expense;
use Illuminate\Support\Facades\DB;

class DashboardRepository
{
    public function getMonthlySummary(int $year)
    {
        $income = MonthlyFee::select(
            DB::raw('MONTH(payment_date) as month'),
            DB::raw('SUM(security_fee + cleaning_fee) as total_income')
        )
            ->whereYear('payment_date', $year)
            ->groupBy(DB::raw('MONTH(payment_date)'))
            ->pluck('total_income', 'month');

        $expense = Expense::select(
            DB::raw('MONTH(date) as month'),
            DB::raw('SUM(amount) as total_expense')
        )
            ->whereYear('date', $year)
            ->groupBy(DB::raw('MONTH(date)'))
            ->pluck('total_expense', 'month');

        // Gabungkan data dalam 12 bulan
        $summary = [];
        for ($m = 1; $m <= 12; $m++) {
            $incomeAmount = $income[$m] ?? 0;
            $expenseAmount = $expense[$m] ?? 0;
            $summary[] = [
                'month' => $m,
                'income' => round($incomeAmount, 2),
                'expense' => round($expenseAmount, 2),
                'balance' => round($incomeAmount - $expenseAmount, 2),
            ];
        }

        return $summary;
    }

    public function getMonthlyDetail(int $month, int $year)
    {
        $income = MonthlyFee::whereMonth('payment_date', $month)
            ->whereYear('payment_date', $year)
            ->get(['id', 'payment_date', 'security_fee', 'cleaning_fee', 'notes']);

        $expense = Expense::whereMonth('date', $month)
            ->whereYear('date', $year)
            ->get(['id', 'date', 'category', 'amount', 'description']);

        return [
            'income' => $income,
            'expense' => $expense,
        ];
    }
}