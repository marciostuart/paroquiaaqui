<?php

namespace App\Services;

use App\Models\TenantDomain;

class DomainVerificationService
{
    public function verify(TenantDomain $domain): bool
    {
        $records = dns_get_record('_paroquia-verificar.'.$domain->host, DNS_TXT) ?: [];
        $found = collect($records)->contains(fn (array $record) => hash_equals($domain->verification_token, trim((string) ($record['txt'] ?? ''))));
        if ($found) $domain->update(['status' => 'active', 'verified_at' => now()]);
        return $found;
    }
}
