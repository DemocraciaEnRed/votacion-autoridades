<?php

namespace App\Providers;

use App\Models\Administrator;
use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Auth\Access\Response;
use Spatie\Permission\Models\Permission;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // GATES FOR PERMISSIONS
        $permissions = Permission::all();
        foreach($permissions as $permission) {

            Gate::define($permission->name, function ($user = null) use ($permission) {

                $administrator = Auth::guard('backend')->user();

                if($administrator->hasPermissionTo($permission)) {
                    return Response::allow();
                }

                return Response::deny();
            });
        }

        // GATES FOR MENU
        Gate::define('menu usuarios', function ($user = null) {

            $administrator = Auth::guard('backend')->user();

            if($administrator->hasAnyPermission(['listar usuarios', 'validar usuarios', 'validar todos los usuarios', 'exportar usuarios'])) {
                return Response::allow();
            }

            return Response::deny();
        });

        Gate::define('menu censo', function ($user = null) {

            $administrator = Auth::guard('backend')->user();

            if($administrator->hasAnyPermission(['listar padrones', 'ver logs padrones', 'ver importar padrones', 'ver exportar padrones'])) {
                return Response::allow();
            }

            return Response::deny();
        });

        Gate::define('menu resultados', function ($user = null) {

            $administrator = Auth::guard('backend')->user();

            if($administrator->hasAnyPermission(['ver resultados', 'exportar resultados'])) {
                return Response::allow();
            }

            return Response::deny();
        });
    }
}
