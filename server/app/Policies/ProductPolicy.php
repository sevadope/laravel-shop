<?php

namespace App\Policies;

use App\AppModelsProduct;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductPolicy
{
    use HandlesAuthorization;

    /**
     * Allow all actions for super admin
     **/
    public function before($user, $ability)
    {
        if ($user->isSuperAdmin()) {
            return true;
        }
    }

    /**
     * Determine whether the user can view any app models products.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the app models product.
     *
     * @param  \App\Models\User  $user
     * @param  \App\AppModelsProduct  $appModelsProduct
     * @return mixed
     */
    public function view(User $user, AppModelsProduct $appModelsProduct)
    {
        return true;
    }

    /**
     * Determine whether the user can create app models products.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->isManager() || $user->isAdmin();
    }

    /**
     * Determine whether the user can update the app models product.
     *
     * @param  \App\Models\User  $user
     * @param  \App\AppModelsProduct  $appModelsProduct
     * @return mixed
     */
    public function update(User $user, AppModelsProduct $appModelsProduct)
    {
        return $user->isManager() || $user->isAdmin();
    }

    /**
     * Determine whether the user can delete the app models product.
     *
     * @param  \App\Models\User  $user
     * @param  \App\AppModelsProduct  $appModelsProduct
     * @return mixed
     */
    public function delete(User $user, AppModelsProduct $appModelsProduct)
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can restore the app models product.
     *
     * @param  \App\Models\User  $user
     * @param  \App\AppModelsProduct  $appModelsProduct
     * @return mixed
     */
    public function restore(User $user, AppModelsProduct $appModelsProduct)
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can permanently delete the app models product.
     *
     * @param  \App\Models\User  $user
     * @param  \App\AppModelsProduct  $appModelsProduct
     * @return mixed
     */
    public function forceDelete(User $user, AppModelsProduct $appModelsProduct)
    {
        return $user->isAdmin();
    }
}
