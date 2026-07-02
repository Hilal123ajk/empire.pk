<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\AdminDashboardService;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __construct(
        private readonly AdminDashboardService $dashboard,
    ) {}

    public function index(): View
    {
        return view('admin.dashboard', [
            'dashboardStats' => $this->dashboard->getStats(),
            'dashboardRecentOrders' => $this->dashboard->getRecentOrders(),
            'dashboardBestsellers' => $this->dashboard->getBestsellers(),
            'dashboardActivity' => $this->dashboard->getRecentActivity(),
        ]);
    }
}
