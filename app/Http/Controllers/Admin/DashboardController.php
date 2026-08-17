<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        abort_unless(auth()->user()->tenant_id || auth()->user()->role === 'master', 403);
        return view('admin.dashboard', ['user' => auth()->user()]);
    }
}
