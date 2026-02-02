<?php

namespace App\Http\Controllers;

use App\Services\DashboardService;
use Illuminate\View\View;

class DashboardController extends Controller
{
    protected DashboardService $service;

    public function __construct(DashboardService $service)
    {
        $this->service = $service;
    }

    /**
     * Display the dashboard
     */
    public function index()
    {
        $data = $this->service->getDashboardData();

        return view('pages.dashboard', $data);
    }
}
