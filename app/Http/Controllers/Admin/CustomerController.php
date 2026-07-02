<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\CustomerService;
use Illuminate\View\View;

class CustomerController extends Controller
{
    public function __construct(
        private readonly CustomerService $customers,
    ) {}

    public function index(): View
    {
        return view('admin.customers.index', [
            'adminCustomers' => $this->customers->getCustomersForAdmin(),
        ]);
    }
}
