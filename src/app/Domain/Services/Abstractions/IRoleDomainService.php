<?php

namespace App\Domain\Services\Abstractions;

use App\Models\Role;

/**
 * Interface IRoleDomainService 
 */
interface IRoleDomainService extends IDomainService
{
    public function any(string $roleName): bool;

    public function findByName(string $roleName): ?Role;
}