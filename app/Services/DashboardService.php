<?php

namespace App\Services;

use App\Repository\DashboardRepository;

class DashboardService
{
    protected $dashboardRepository;

    public function __construct(DashboardRepository $dashboardRepository)
    {
        $this->dashboardRepository = $dashboardRepository;
    }

    public function getMonthlySummary($year)
    {
        return $this->dashboardRepository->getMonthlySummary($year);
    }

    public function getMonthlyDetail($month, $year)
    {
        return $this->dashboardRepository->getMonthlyDetail($month, $year);
    }
}