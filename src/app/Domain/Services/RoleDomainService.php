<?php

namespace App\Domain\Services;

use App\Domain\Services\Abstractions\IRoleDomainService;
use App\Models\Role;

/**
 * Role Domain Service.
 */
class RoleDomainService extends DomainService implements IRoleDomainService
{
    /**
     * Check if the role exists.
     * 
     * @param string $name
     * @return bool
     */
    public function any($name): bool
    {
        return $this->query()->any($name);
    }

    /**
     * Get the role by name.
     * 
     * @param string $name
     * @return ?Role
     */
    public function findByName($name): ?Role
    {
        return $this->query()->findByName($name);
    }
}