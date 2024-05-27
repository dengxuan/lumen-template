<?php

namespace App\Providers;

use App\Domain\Services\Abstractions as I;
use App\Domain\Services as S;
use Illuminate\Support\ServiceProvider;

/**
 * Domain Service Provider.
 */
class DomainServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(I\IUserDomainService::class, S\UserDomainService::class);
        $this->app->bind(I\IRoleDomainService::class, S\RoleDomainService::class);
    }
}