<?php

namespace Tests\Feature;

use App\Models\Tenant;
use App\Models\TenantDomain;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TenantResolutionTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_verified_tenant_domain_resolves_its_public_site(): void
    {
        $tenant = Tenant::create([
            'slug' => 'paroquia-piloto',
            'legal_name' => 'Paróquia Piloto',
            'display_name' => 'Paróquia Piloto',
        ]);

        TenantDomain::create([
            'tenant_id' => $tenant->id,
            'host' => 'paroquia-piloto.v2.paroquiaaqui.com.br',
            'kind' => 'staging',
            'status' => 'active',
            'verification_token' => str()->random(64),
        ]);

        $this->get('http://paroquia-piloto.v2.paroquiaaqui.com.br/')
            ->assertOk()
            ->assertSee('Paróquia Piloto');
    }

    public function test_legacy_slug_url_resolves_the_same_tenant(): void
    {
        $tenant = Tenant::create([
            'slug' => 'paroquia-piloto',
            'legal_name' => 'Paróquia Piloto',
            'display_name' => 'Paróquia Piloto',
        ]);

        $this->get('/paroquia-piloto')->assertOk()->assertSee($tenant->display_name);
    }
}
