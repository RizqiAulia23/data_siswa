<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    /**
     * Helper to authenticate an administrative user.
     */
    protected function actingAsAdmin(?User $user = null): User
    {
        $user ??= User::factory()->create([
            'role' => 'admin',
        ]);

        $this->actingAs($user);

        return $user;
    }

    /**
     * Helper to authenticate a teacher user.
     */
    protected function actingAsGuru(?User $user = null): User
    {
        $user ??= User::factory()->create([
            'role' => 'guru',
        ]);

        $this->actingAs($user);

        return $user;
    }

    /**
     * Helper to authenticate a student user.
     */
    protected function actingAsSiswa(?User $user = null): User
    {
        $user ??= User::factory()->create([
            'role' => 'siswa',
        ]);

        $this->actingAs($user);

        return $user;
    }
}
