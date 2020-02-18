<?php

namespace App\Models\Auth;

use Illuminate\Database\Eloquent\Model;
use App\Models\Auth\Role;

class Permission extends Model
{
    protected $table = 'permissions';

    protected $fillable = [
    	'id',
    	'action',
    ];

    /*|==========| Relationships |==========|*/

    public function roles()
    {
    	return $this->belongsToMany(
    		Role::class,
    		'role_permission',
    		'perm_id',
    		'role_id'
    	);
    }
}
