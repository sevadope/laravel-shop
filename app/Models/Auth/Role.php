<?php

namespace App\Models\Auth;

use Illuminate\Database\Eloquent\Model;
use App\Models\Auth\Permission;

class Role extends Model
{
    public const DEFAULT = 1;

    protected $table = 'roles';

    protected $fillable = [
    	'id',
    	'name',
    ];	

    /*|==========| Relationships |==========|*/

    public function permissions()
    {
    	return $this->belongsToMany(
    		Permission::class,
    		'role_permission',
    		'role_id',
    		'perm_id'
    	);
    }
}
