<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TenantDomain;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;
use App\Services\DomainVerificationService;

class TenantDomainController extends Controller
{
    public function index(): View
    {
        $tenant = auth()->user()->tenant;
        abort_unless($tenant, 403);
        return view('admin.domains.index', ['tenant' => $tenant, 'domains' => $tenant->domains()->latest()->get()]);
    }

    public function store(Request $request): RedirectResponse
    {
        $tenant = auth()->user()->tenant;
        abort_unless($tenant, 403);
        $host = strtolower(trim((string) $request->validate(['host' => ['required', 'string', 'max:253']])['host']));
        $host = preg_replace('#^https?://#', '', $host);
        $host = rtrim(explode('/', $host)[0], '.');
        abort_unless(filter_var($host, FILTER_VALIDATE_DOMAIN, FILTER_FLAG_HOSTNAME), 422, 'Domínio inválido.');

        $tenant->domains()->create(['host' => $host, 'kind' => 'custom', 'status' => 'pending', 'verification_token' => Str::random(48)]);
        return back()->with('status', 'Domínio cadastrado. Configure o DNS antes da verificação.');
    }

    public function verify(TenantDomain $domain, DomainVerificationService $verifier): RedirectResponse
    {
        abort_unless($domain->tenant_id === auth()->user()->tenant_id, 404);
        return back()->with('status', $verifier->verify($domain) ? 'DNS confirmado. Domínio ativado.' : 'Registro TXT ainda não foi localizado. Aguarde a propagação do DNS e tente novamente.');
    }
}
