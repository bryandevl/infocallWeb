<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Master\Models\RoleUser;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes;
    protected $softDelete = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'last_login', 'attempts_login'
    ];

    protected $appends  = [
        'role_id', 'role_slug'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getRoleIdAttribute()
    {
        $roleUser = RoleUser::where("user_id", $this->id)->first();
        if (!is_null($roleUser)) {
            return $roleUser->role_id;
        }
        return null;
    }
    public function getRoleSlugAttribute()
    {
        $roleUser = RoleUser::with("role")->where("user_id", $this->id)->first();
        if (!is_null($roleUser)) {
            if (!is_null($roleUser->role)) {
                return $roleUser->role->slug;
            }
            return null;
        }
        return null;
    }
}
