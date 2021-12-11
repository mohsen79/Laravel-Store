<?php

namespace App\Providers;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        User::class => UserPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        Gate::define('edit-comment', function ($user, $current_comment) {
            return in_array($current_comment, $user->comments->pluck('id')->toArray());
        });
        Gate::define('edit-user', function ($user, $current_user) {
            return $user == $current_user;
        });
        foreach (Permission::all() as $permissions) {
            Gate::define($permissions->name, function ($user) use ($permissions) {
                return $user->HasPermission($permissions);
            });
        }
        foreach (Role::all() as $roles) {
            Gate::define($roles->name, function ($user) use ($roles) {
                return $user->HasRole($roles);
            });
        }
    }
}
