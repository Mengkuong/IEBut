<?php

namespace App\Providers;


use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
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
        if (! $this->app->routesAreCached()){
            Passport::routes();
        }

        Gate::define('manage-users', function (User $user){
            if ($user->role_id===2){
                return true;
            }
        });
        Gate::define('manage-admin', function (User $user){
            if ($user->role_id===1){
                return true;
            }
        });
        Gate::define('admin-post', function (User $user){
            if ($user->role_id===2){
                return true;
            }
        });
        Gate::define('admin-certificate', function (User $user){
            if ($user->role_id===2){
                return true;
            }
        });
        Gate::define('view-post', function (User $user){
            if ($user->role_id===3){
                return true;
            }
        });
        Gate::define('user-profile', function (User $user){
            if ($user->role_id===3){
                return true;
            }
        });
        Gate::define('user-view-certificate', function (User $user){
            if ($user->role_id===3){
                return true;
            }
        });
        Gate::define('user-sell-shares', function (User $user){
            if ($user->role_id===3){
                return true;
            }
        });
        Gate::define('view-finance-super-admin', function (User $user){
            if ($user->role_id===1){
                return true;
            }
        });
        Gate::define('view-finance-admin', function (User $user){
            if ($user->role_id===2){
                return true;
            }
        });
        Gate::define('view-finance-user', function (User $user){
            if ($user->role_id===3){
                return true;
            }
        });
        Gate::define('finance-create', function (User $user){
            if ($user->role_id===4){
                return true;
            }
        });
        Gate::define('super-admin-view-post', function (User $user){
            if ($user->role_id===1){
                return true;
            }
        });
        Gate::define('user-buy', function (User $user){
            if ($user->role_id===3){
                return true;
            }
        });
        Gate::define('accept-reject', function (User $user){
            if ($user->role_id===1){
                return true;
            }
        });
        Gate::define('transfer-super', function (User $user){
            if ($user->role_id===1){
                return true;
            }
        });
        Gate::define('transfer-user', function (User $user){
            if ($user->role_id===3){
                return true;
            }
        });
        Gate::define('view-sell', function (User $user){
            if ($user->role_id===1){
                return true;
            }
        });
        Passport::tokensExpireIn(Carbon::now()->addDays(1));
        Passport::refreshTokensExpireIn(Carbon::now()->week(7));
        Passport::personalAccessTokensExpireIn(Carbon::now()->week(7));
    }
}
