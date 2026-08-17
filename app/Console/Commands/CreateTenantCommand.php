<?php

namespace App\Console\Commands;

use App\Models\Tenant;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateTenantCommand extends Command
{
    protected $signature = 'tenant:create {slug} {name} {email} {--password=}';
    protected $description = 'Cria uma paróquia e o primeiro administrador, sem expor senha em logs.';

    public function handle(): int
    {
        $password = $this->option('password') ?: $this->secret('Senha do administrador');
        if (strlen((string) $password) < 12) { $this->error('Use uma senha com ao menos 12 caracteres.'); return self::FAILURE; }
        $tenant = Tenant::firstOrCreate(['slug' => $this->argument('slug')], ['legal_name' => $this->argument('name'), 'display_name' => $this->argument('name'), 'email' => $this->argument('email')]);
        User::updateOrCreate(['email' => $this->argument('email')], ['tenant_id' => $tenant->id, 'name' => 'Administrador '.$tenant->display_name, 'role' => 'admin', 'password' => Hash::make($password)]);
        $this->info('Paróquia e administrador criados.');
        return self::SUCCESS;
    }
}
