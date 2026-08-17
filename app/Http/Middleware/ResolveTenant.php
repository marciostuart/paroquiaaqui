<?php

namespace App\Http\Middleware;

use App\Models\Tenant;
use App\Support\TenantContext;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ResolveTenant
{
    public function handle(Request $request, Closure $next): Response
    {
        $host = strtolower($request->getHost());
        $tenant = Tenant::query()
            ->where('status', 'active')
            ->whereHas('domains', fn ($query) => $query->where('host', $host)->where('status', 'active'))
            ->first();

        if (! $tenant && $slug = $request->route('tenant')) {
            $tenant = Tenant::query()->where('slug', $slug)->where('status', 'active')->first();
        }

        if ($tenant) {
            app(TenantContext::class)->set($tenant);
            $request->attributes->set('tenant', $tenant);
        }

        return $next($request);
    }
}
