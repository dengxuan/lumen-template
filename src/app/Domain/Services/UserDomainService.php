<?php

namespace App\Domain\Services;

use App\Models\User;
use App\Domain\Services\Abstractions\IUserDomainService;

/**
 * User domain service.
 */
class UserDomainService extends DomainService implements IUserDomainService
{
    public function __construct()
    {
        parent::__construct(User::class);
    }

    public function any($username, $email)
    {
        $user = $this->query()->wheres('name', $username)->orWhere('email', $email)->first();
        return $user === null;
    }

    public function maxId()
    {
        return $this->query()->max('id');
    }

    public function findByEmail($email)
    {
        return $this->query()->where('email', $email)->first();
    }

    public function findByName($name)
    {
        return $this->query()->where('name', $name)->first();
    }

    public function resetPassword($email, $password)
    {
        $user = $this->findByEmail($email);
        $user->password = $password;
        $user->save();
    }

    public function changePassword($id, $password)
    {
        $user = $this->find($id);
        $user->password = $password;
        $user->save();
    }

    public function forgetPassword($email)
    {
        $user = $this->findByEmail($email);
        $user->password = '';
        $user->save();
    }
}