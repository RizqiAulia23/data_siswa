<?php

namespace App\Policies;

use App\Models\User;

class LogAktivitasPolicy extends BaseAcademicPolicy
{
    public function view(User $user, mixed $_log): bool
    {
        return $user->isAdmin();
    }

    public function create(User $user): bool
    {
        return false;
    }

    public function update(User $user, mixed $_log): bool
    {
        return false;
    }

    public function delete(User $user, mixed $_log): bool
    {
        return false;
    }
}
