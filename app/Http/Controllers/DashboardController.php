<?php

namespace App\Http\Controllers;

use App\Services\DashboardService;
use App\Services\MonitoringService;

class DashboardController extends Controller
{
    public function __construct(
        private readonly DashboardService $dashboardService,
        private readonly MonitoringService $monitoringService
    ) {
    }

    public function officer()
    {
        return view('dashboard.officer', $this->dashboardService->getOfficerStats(auth()->user()));
    }

    public function lead()
    {
        return view('dashboard.lead', $this->dashboardService->getLeadStats(auth()->user()));
    }

    public function ho()
    {
        return view('dashboard.ho', $this->dashboardService->getHOStats());
    }

    public function regionalOffice()
    {
        $scorecard = $this->monitoringService->buildRegionalOfficeScorecard(auth()->user());
        $categories = \App\Models\TaskCategory::all();

        return view('monitoring.regional-office', compact('scorecard', 'categories'));
    }

    public function officerMonitoring()
    {
        $scorecard = $this->monitoringService->buildOfficerScorecard(auth()->user());
        $categories = \App\Models\TaskCategory::all();

        return view('monitoring.officer', compact('scorecard', 'categories'));
    }
}