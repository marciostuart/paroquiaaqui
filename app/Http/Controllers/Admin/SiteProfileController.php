<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\SiteProfile;
use Illuminate\Http\Request;
class SiteProfileController extends Controller {
 public function edit(Request $request) { $tenant=$request->user()->tenant; abort_unless($tenant,403); $profile=SiteProfile::firstOrCreate(['tenant_id'=>$tenant->id]); return view('admin.site-profile.edit',compact('profile','tenant')); }
 public function update(Request $request) { $tenant=$request->user()->tenant; abort_unless($tenant,403); $data=$request->validate(['about'=>'nullable|string|max:5000','address'=>'nullable|string|max:255','city'=>'nullable|string|max:120','state'=>'nullable|string|size:2','contact_email'=>'nullable|email|max:255','contact_phone'=>'nullable|string|max:30','instagram_url'=>'nullable|url|max:255']); SiteProfile::updateOrCreate(['tenant_id'=>$tenant->id],$data); return back()->with('status','Dados do site atualizados.'); }
}
