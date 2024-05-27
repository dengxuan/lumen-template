<?php

namespace App\Domain\Services\Abstractions;

/** 
 * Interface IUserDomainService.
 */
interface IUserDomainService extends IDomainService
{
    /**
     * Check if the user exists.
     */
    public function any($username, $email);

    /**
     * Get the maximum id.
     */
    public function maxId();

    /**
     * Get the user by email.
     */
    public function findByEmail($email);

    /**
     * Get the user by name.
     */
    public function findByName($name);

    /**
     * Reset password
     */
    public function resetPassword($email, $password);

    /**
     * Change password
     */
    public function changePassword($id, $password);

    /**
     * Forget password
     */
    public function forgetPassword($email);
}