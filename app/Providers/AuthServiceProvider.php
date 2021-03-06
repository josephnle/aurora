<?php

namespace App\Providers;

use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Award' => 'App\Policies\AwardPolicy',
	    'App\Invite' => 'App\Policies\InvitePolicy',
	    'App\Submission' => 'App\Policies\SubmissionPolicy',
        'App\Team' => 'App\Policies\TeamPolicy',
	    'App\User' => 'App\Policies\UserPolicy',
    ];

    /**
     * Register any application authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
    }
}
