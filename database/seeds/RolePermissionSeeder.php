<?php

use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
	private $roles;
	private $permissions;
	private $verbs;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $table = [];

    	foreach (AuthSeeder::ROLES_PERMISSIONS as $role_name => $entities) {

    		$role_id = $this->getRoles()->where('name', $role_name)->first()->id;
    		$table = array_merge($table, $this->makeRowsForRole($role_id, $entities));
    	}

    	DB::table('role_permission')->insert($table);
    }

    private function makeRowsForRole(int $role_id, array $entities)
    {
    	$rows = [];

    	foreach ($entities as $entity => $verbs) {

    		if (!empty($helpers = $this->getWithoutVerbs($verbs))) {
    			$verbs = $this->resolveHelpers($helpers);
    		}

    		foreach ($verbs as $verb) {

    			$perm_id = $this->getPermissions()->where(
    				'action',
    				AuthSeeder::makeAction($verb, $entity)
    			)->first()->id;

    			$rows[] = $this->makeRow($role_id, $perm_id);
    		}
    	}

    	return $rows;
    }	

    private function makeRow(int $role_id, int $perm_id)
    {
    	return [
    		'role_id' => $role_id,
    		'perm_id' => $perm_id,
    	];
    }

    private function resolveHelpers(array $helpers)
    {
    	foreach ($helpers as $helper) {
    		if ($helper === '*') {
    			return $this->getAllVerbs();
    		}

    		if (strstr($helper, '#except:')) {

    			$except = explode(',', substr($helper, strlen('#except:')));

    			if ($this->hasVerbsOnly($except)) {
    				return array_diff($this->getAllVerbs(), $except);
    			}
    		}

    		throw new \LogicException("Unknown verb '$helper'!");
    	}
    }

    private function getWithoutVerbs(array $verbs)
    {
    	return array_diff($verbs, $this->getAllVerbs());
    }

    private function hasVerbsOnly(array $verbs)
    {
    	return empty($this->getWithoutVerbs($verbs));
    }

    private function getAllVerbs()
    {
    	return $this->verbs ?? $this->verbs = AuthSeeder::VERBS;
    }

    private function getRoles()
    {
        return $this->roles ?? $this->roles = DB::table('roles')->get();
    }

    private function getPermissions()
    {
        return $this->permissions ?? $this->permissions = DB::table('permissions')->get();
    }
}
