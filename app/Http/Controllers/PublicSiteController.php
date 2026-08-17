<?php

namespace App\Http\Controllers;

use App\Support\TenantContext;
use App\Models\MassSchedule;
use App\Models\SiteProfile;
use Illuminate\View\View;

class PublicSiteController extends Controller
{
    public function show(TenantContext $context): View
    {
        abort_unless($tenant = $context->get(), 404);

        $profile = SiteProfile::where('tenant_id', $tenant->id)->first();
        $masses = MassSchedule::where('tenant_id', $tenant->id)->where('is_active', true)->orderBy('sort_order')->get();
        return view('public-site.home', compact('tenant', 'profile', 'masses'));
    }
}
