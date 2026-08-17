<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tenant extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug', 'legal_name', 'display_name', 'email', 'phone', 'status',
        'primary_color', 'secondary_color', 'logo_key', 'timezone',
    ];

    public function domains(): HasMany
    {
        return $this->hasMany(TenantDomain::class);
    }
}
