<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\MassSchedule;
use Illuminate\Http\Request;
class MassScheduleController extends Controller {
 public function index(Request $request){$tenant=$request->user()->tenant;abort_unless($tenant,403);$masses=MassSchedule::where('tenant_id',$tenant->id)->orderBy('sort_order')->get();return view('admin.masses.index',compact('masses'));}
 public function store(Request $request){$tenant=$request->user()->tenant;abort_unless($tenant,403);$data=$request->validate(['community_name'=>'required|string|max:120','address'=>'nullable|string|max:255','schedule'=>'required|string|max:255','sort_order'=>'nullable|integer|min:0']);$data['tenant_id']=$tenant->id;MassSchedule::create($data);return back()->with('status','Horário adicionado.');}
 public function destroy(Request $request, MassSchedule $mass){abort_unless($mass->tenant_id===$request->user()->tenant_id,403);$mass->delete();return back()->with('status','Horário removido.');}
}
