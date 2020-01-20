<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Auth\Role;
use App\Models\Auth\Permission;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'role_id',
        'first_name',
        'last_name',
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /*|==========| Relationships |==========|*/

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function permissions()
    {
        return $this->belongsToMany(
            Permission::class,
            'role_permission',
            'role_id',
            'perm_id',
            'role_id'
        );
    }

    /*|====================|*/

    public function hasPermissionTo(string $action)
    {
        return $this->permissions()->where('action', $action)->exists();
    }
}
