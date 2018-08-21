<?php

namespace App\Services;

interface AdminUserServiceInterface extends AuthenticatableServiceInterface
{
    public function getAllCoach();
}
