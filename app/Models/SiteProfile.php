<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class SiteProfile extends Model { protected $fillable=['tenant_id','about','address','city','state','contact_email','contact_phone','instagram_url']; }
