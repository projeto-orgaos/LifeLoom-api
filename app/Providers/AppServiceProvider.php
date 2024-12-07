<?php

namespace App\Providers;

use App\Http\Controllers\OrganTypeController;
use App\Repositories\AddressRepository;
use App\Repositories\Contracts\AddressRepositoryInterface;
use App\Repositories\Contracts\HospitalRepositoryInterface;
use App\Repositories\Contracts\OrganRepositoryInterface;
use App\Repositories\Contracts\OrganTypeRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Repositories\HospitalRepository;
use App\Repositories\OrganRepository;
use App\Repositories\OrganTypeRepository;
use App\Repositories\UserRepository;
use App\Services\AddressService;
use App\Services\AuthService;
use App\Services\Contracts\AddressServiceInterface;
use App\Services\Contracts\AuthServiceInterface;
use App\Services\Contracts\HospitalServiceInterface;
use App\Services\Contracts\OrganServiceInterface;
use App\Services\Contracts\OrganTypeServiceInterface;
use App\Services\Contracts\UserServiceInterface;
use App\Services\HospitalService;
use App\Services\OrganService;
use App\Services\OrganTypeService;
use App\Services\UserService;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\ServiceProvider;
use L5Swagger\L5SwaggerServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
        $this->app->register(L5SwaggerServiceProvider::class);
        // Provide interfaces userservice and repository
        $this->app->bind(UserServiceInterface::class, UserService::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);

        $this->app->bind(AddressRepositoryInterface::class, AddressRepository::class);
        $this->app->bind(AddressServiceInterface::class, AddressService::class);

        $this->app->bind(OrganServiceInterface::class, OrganService::class);
        $this->app->bind(OrganRepositoryInterface::class, OrganRepository::class);

        $this->app->bind(OrganTypeServiceInterface::class, OrganTypeService::class);
        $this->app->bind(OrganTypeRepositoryInterface::class, OrganTypeRepository::class);
;

        $this->app->bind(AuthServiceInterface::class, AuthService::class);

        $this->app->bind(HospitalServiceInterface::class, HospitalService::class);
        $this->app->bind(HospitalRepositoryInterface::class, HospitalRepository::class);

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        ResetPassword::createUrlUsing(function (object $notifiable, string $token) {
            return config('app.frontend_url') . "/password-reset/$token?email={$notifiable->getEmailForPasswordReset()}";
        });
    }
}
