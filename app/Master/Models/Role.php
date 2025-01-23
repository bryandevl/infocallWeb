<?php namespace App\Master\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends \App\BaseModel
{
    protected $table = 'roles';

    public function modules() {
        return $this->hasMany("App\Master\Models\RoleModule", "role_id", "id");
    }
}
