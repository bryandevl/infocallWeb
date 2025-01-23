<?php namespace App\Master\Models;

use Illuminate\Database\Eloquent\Model;

class RoleUser extends Model
{
    protected $table = 'role_user';

    public function role() {
        return $this->hasOne("App\Master\Models\Role", "id", "role_id");
    }
}
