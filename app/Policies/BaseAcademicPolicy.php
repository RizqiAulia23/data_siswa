<?php

namespace App\Policies;

use App\Models\User;

abstract class BaseAcademicPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isAdmin() || $user->isGuru();
    }

    public function view(User $user, mixed $_model): bool
    {
        return $user->isAdmin() || $user->isGuru();
    }

    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    public function update(User $user, mixed $_model): bool
    {
        return $user->isAdmin();
    }

    public function delete(User $user, mixed $_model): bool
    {
        return $user->isAdmin();
    }

    public function viewSalary(User $user, mixed $_model): bool
    {
        return $user->isAdmin();
    }
}
