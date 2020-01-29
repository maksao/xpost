<?php

namespace App\Providers;

use Blade;
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
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Blade::if('admin', function () {
            if(\Auth::check()) {
                return \Auth::user()->isAdmin();
            }
            return false;
        });

        Blade::if('employee', function () {
            if(\Auth::check()) {
                return \Auth::user()->isEmployee();
            }
            return false;
        });

        Blade::if('contractor', function () {
            if(\Auth::check()) {
                return \Auth::user()->isContractor();
            }
            return false;
        });
    }
}
