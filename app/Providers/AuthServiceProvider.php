<?php

namespace App\Providers;

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
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //define roles

        Gate::define('auth', function($user){
            return !is_null($user);
        });

        Gate::define('is_manager_admin', function($user){
                return $user->get_user_type->type > '3';

        });

        Gate::define('is_we_schedule_manager_admin', function($user){
            if(str_contains(url()->current(), 'we-schedule') || str_contains(url()->current(), 'localhost')) {

                return $user->get_user_type->type > '3';
            }

        });

        Gate::define('is_case_manage', function($user) {
            if(str_contains(url()->current(), 'casemanage')) {

                return $user;
            }
        });

        Gate::define('is_user', function($user){
            return $user->get_user_type->name == 'CYSW';
        });

        Gate::define('test-budget', function($user){
          //  return $user->id == '4'; //user id 2 should now see the blog menu
        });

        Gate::define('can_use_expense_link', function($user){
            if(str_contains(url()->current(), 'casemanage')) {

                   return $user->get_user_type->type >= 3.0 && $user->get_user_type->type <= 10.0;
            }
        });

        //
    }
}
