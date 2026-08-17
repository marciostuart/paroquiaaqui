<?php

namespace App\Http\Controllers;

use App\Support\TenantContext;
use Illuminate\View\View;

class PublicSiteController extends Controller
{
    public function show(TenantContext $context): View
    {
        abort_unless($tenant = $context->get(), 404);

        return view('public-site.home', compact('tenant'));
    }
}
