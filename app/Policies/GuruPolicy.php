<?php

namespace App\Policies;

use App\Models\Guru;
use App\Models\User;

class GuruPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isAdmin() || $user->isGuru();
    }

    public function view(User $user, Guru $guru): bool
    {
        return $user->isAdmin() || $user->isGuru();
    }

    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    public function update(User $user, Guru $guru): bool
    {
        return $user->isAdmin();
    }

    public function delete(User $user, Guru $guru): bool
    {
        return $user->isAdmin();
    }

    public function viewSalary(User $user, Guru $guru): bool
    {
        return $user->isAdmin();
    }
}
