<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tenants', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('legal_name');
            $table->string('display_name');
            $table->string('email')->nullable();
            $table->string('phone', 30)->nullable();
            $table->string('status', 32)->default('active')->index();
            $table->string('primary_color', 7)->default('#6600A5');
            $table->string('secondary_color', 7)->default('#DF3DC0');
            $table->string('logo_key')->nullable();
            $table->string('timezone')->default('America/Sao_Paulo');
            $table->timestamps();
        });

        Schema::create('tenant_domains', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained()->cascadeOnDelete();
            $table->string('host')->unique();
            $table->string('kind', 20)->default('custom');
            $table->string('status', 20)->default('pending')->index();
            $table->string('verification_token', 64)->unique();
            $table->timestamp('verified_at')->nullable();
            $table->timestamps();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('tenant_id')->nullable()->after('id')->constrained('tenants')->nullOnDelete();
            $table->string('role', 30)->default('operator')->after('email_verified_at')->index();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropConstrainedForeignId('tenant_id');
            $table->dropColumn('role');
        });
        Schema::dropIfExists('tenant_domains');
        Schema::dropIfExists('tenants');
    }
};
