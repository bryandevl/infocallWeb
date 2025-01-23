<?php namespace App\Master\Controllers;

use App\Http\Controllers\Controller;
use App\Master\Models\Business;
use App\Master\Models\Profile;
use Illuminate\Http\Request;
use Validator;
use DB;
use App\Helpers\ValidatorHelper;
use App\Helpers\DataTableHelper;
use App\Master\Models\Role;
use App\Master\Models\RoleUser;
use App\Master\Models\Module;
use App\Master\Models\RoleModule;
use App\Master\Requests\RoleRequest;

class RoleController extends Controller
{
	public function index(Request $request)
	{
		if ($request->ajax()) {
			$url = $request->url;
			return datatables()->of(
	            Role::select("*")->where("slug", "<>", "superadmin")
	        )->toJson();
		}
		$modules = Module::with([
            "childModules" => function($q) {
                $q->select([
                    "id",
                    "class_icon",
                    "url",
                    "name",
                    "module_parent_id"
                ]);
            }
        ])->where([
            "status" => 1,
        ])->whereRaw("module_parent_id IS NULL")
        ->get()
        ->toArray();

		return view("master.role.index", compact("modules"));
	}
	public function show($roleId = "")
	{
		$roleObj = Role::with("modules")->find($roleId);
        
        return json_encode($roleObj);
	}
	public function store(RoleRequest $request)
	{
        $roleId = ($request->has("role_id"))? $request->role_id : null;
        $obj = null;

        DB::beginTransaction();
        try {
        	$response = [
        		"rst" => 1,
        		"msj" => "",
        		"obj" => ""
        	];
        	if (!is_null($roleId) && $roleId !="") {
        		$roleSlugExits = 
        			Role::where("slug", $request->slug)
        				->where("id", "<>", $roleId)
        				->first();
        		if (!is_null($roleSlugExits)) {
        			$response["rst"] = 2;
        			$response["msj"] = "El Rol {$roleSlugExits->name} ya tiene asignada la Abreviatura que requiere actualizar";
        			return response($response);
        		}
        		$obj = Role::find($roleId);
	        	$response["msj"] = "Rol {$obj->name} Editado";
	        } else {
	        	$obj = new Role;
	        	$response["msj"] = "Rol {$request->name} Creado";
	        }
	        $obj->name = $request->name;
	        $obj->slug = $request->slug;

	        if ($request->has("status") && $request->status !="") {
	        	$obj->status = $request->status;
	        }
	        $obj->save();
	        DB::commit();

	        RoleModule::where("role_id", $obj->id)->delete();

	        if ($request->has("module_id")) {
	        	foreach($request->module_id as $key => $value) {
	        		$roleModuleObj = new RoleModule;
	        		$roleModuleObj->role_id = $obj->id;
	        		$roleModuleObj->module_id = $value;
	        		$roleModuleObj->save();
	        	}
	        }
	        $roleModuleObj = new RoleModule;
	        $roleModuleObj->role_id = $obj->id;
	        $roleModuleObj->module_id = 1;
	        $roleModuleObj->save();
	        \Cache::forget("modulesFullAccess");
	        return response($response);
        } catch (Exception $e) {
        	return response(["rst" => 2, "msj" => "Error de BD"]);
        }
	}
	public function destroy($roleId = "")
    {
    	$totalUsers = RoleUser::where("role_id", $roleId)->count();
    	if ((int)$totalUsers > 0) {
    		return response(["rst" => 2, "msj" => "Existe usuarios asignados con este Rol, por lo cual no puede eliminarse"]);
    	}
        $role = Role::find($roleId);
        $name = $role->name;

        if (in_array($role->slug, config("crreportes.roles.fullaccess"))) {
        	return response(["rst" => 2, "msj" => "Rol {$name} no puede ser eliminado porque es reservado para Acceso Total"]);
        }
        
        $role->delete();
        \Cache::forget("modulesFullAccess");
        return response(["rst" => 1, "msj" => "Rol {$name} Eliminado con Éxito"]);
    }
}