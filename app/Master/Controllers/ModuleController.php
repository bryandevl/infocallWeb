<?php namespace App\Master\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use DB;
use App\Master\Models\Role;
use App\Master\Models\Module;
use App\Master\Models\RoleUser;
use App\Master\Models\RoleModule;
use App\Master\Requests\RoleRequest;

class ModuleController extends Controller
{
	public function index(Request $request)
	{
		if ($request->ajax()) {
			$childs = $request->has("withChilds")? $request->withChilds : false;
			if ($childs == "false") {
				$childs = false;
			}
			if ($childs == "true") {
				$childs = true;
			}
			if (!$childs) {
				return datatables()->of(
		            Module::whereRaw("module_parent_id IS NULL AND id <> 1")
		        )->toJson();
			} else {
				return datatables()->of(
		            Module::select(
		            	"module.*",
		            	DB::raw("IFNULL(mod.name, '') AS moduleParent")
		            )
		            ->leftJoin("module AS mod", "mod.id", "=", "module.module_parent_id")
		            ->whereRaw("module.module_parent_id IS NOT NULL AND mod.module_parent_id IS NULL")
		        )->toJson();
			}
			
		}
		$modulesParent = 
			Module::where("status", 1)->whereRaw("module_parent_id IS NULL AND id <> 1 ")->get();

		return view("master.module.index", compact("modulesParent"));
	}
	public function show($moduleId = "")
	{
		$moduleObj = Module::find($moduleId);
        
        return json_encode($moduleObj);
	}
	public function store(Request $request)
	{
        $moduleId = $request->has("module_id")? $request->module_id : null;
        $moduleParentId = $request->has("module_parent_id")? $request->module_parent_id : null; 
        $obj = null;

        DB::beginTransaction();
        try {
        	$response = [
        		"rst" => 1,
        		"msj" => "",
        		"obj" => ""
        	];
        	if (!is_null($moduleId) && $moduleId !="") {
        		$obj = Module::find($moduleId);
	        	$response["msj"] = "Módulo {$obj->name} Editado";
	        } else {
	        	$obj = new Module;
	        	$response["msj"] = "Módulo {$request->name} Creado";
	        }
	        $obj->name = $request->name;
	        $obj->module_parent_id = $moduleParentId;
	        $obj->order = $request->order;
	        $obj->visible = $request->visible;
	        $obj->url = $request->url;
	        $obj->save();

	        if (is_null($moduleParentId)) {
	        	$obj->class_icon = $request->class_icon;
	        	$obj->num_childs = Module::where("module_parent_id", $obj->id)->count();
	        } else {
	        	$childs = Module::where("module_parent_id", $moduleParentId)->count();
	        	Module::where("id", $moduleParentId)->update(["num_childs" => $childs]);
	        }

	        if ($request->has("status") && $request->status !="") {
	        	$obj->status = $request->status;
	        }
	        $obj->save();
	        DB::commit();
	        \Cache::forget("modulesFullAccess");
	        return response($response);
        } catch (Exception $e) {
        	return response(["rst" => 2, "msj" => "Error de BD"]);
        }
	}
	public function destroy($moduleId = "")
    {
    	$childs = Module::where("module_parent_id", $moduleId)->count();
    	if ((int)$childs > 0) {
    		return response(["rst" => 2, "msj" => "El Módulo tiene submódulos, no puede eliminarlo"]);
    	}
    	$roleModuleCounts = RoleModule::where("module_id", $moduleId)->count();
    	if ((int)$roleModuleCounts > 0) {
    		return response(["rst" => 2, "msj" => "El Módulo que quiere eliminar está asignado a uno o más roles, por favor verificar"]);
    	}
    	$module = Module::find($moduleId);
    	$name = $module->name;
    	$module->delete();
    	\Cache::forget("modulesFullAccess");

        return response(["rst" => 1, "msj" => "Módulo {$name} Eliminado con Éxito"]);
    }
}