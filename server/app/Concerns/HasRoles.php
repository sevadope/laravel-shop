<?php

namespace App\Concerns;

trait HasRoles 
{
	protected $roles = [
		'public' => 'public',
		'manager' => 'manager',
		'admin' => 'admin',
		'super_admin' => 'super_admin',
	];

	abstract public function getRole();

	public static function getDefaultRole()
	{
		return 'public';
	}

	public function isManager()
	{
		return $this->getRole() === $this->roles['manager'];
	}

	public function isAdmin()
	{
		return $this->getRole() === $this->roles['admin'];
	}

	public function isSuperAdmin()
	{
		return $this->getRole() === $this->roles['super_admin'];
	}

	public function getRoles()
	{
		return $this->roles;
	}
}	