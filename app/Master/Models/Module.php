<?php namespace App\Master\Models;

class Module extends \App\BaseModel
{
	protected $table = "module";

	public function parentModule()
	{
		return $this->hasOne("App\Master\Models\Module", "id", "module_parent_id");
	}
	public function childModules()
	{
		return $this->hasMany("App\Master\Models\Module", "module_parent_id", "id");
	}
	public function knowledgeBase()
	{
		return $this->hasMany("App\Master\Models\KnowledgeBaseModule", "module_id", "id");
	}
}
