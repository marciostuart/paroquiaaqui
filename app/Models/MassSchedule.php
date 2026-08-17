<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class MassSchedule extends Model { protected $fillable=['tenant_id','community_name','address','schedule','sort_order','is_active']; }
