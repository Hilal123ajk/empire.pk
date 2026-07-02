<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::query()->updateOrCreate(
            ['email' => 'hilaldev123@gmail.com'],
            [
                'name' => 'Hilal Ahmad',
                'password' => 'Ajk_573@ceoempirepk',
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );

        User::query()->updateOrCreate(
            ['email' => 'manager@empire.pk.com'],
            [
                'name' => 'Store Manager',
                'password' => 'Empire@Manager2026',
                'role' => 'manager',
                'email_verified_at' => now(),
            ]
        );
    }
}
