<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserPhoto;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory(45)
            ->has(
                UserPhoto::factory()
                    ->state(function (array $attributes, User $user) {
                    return ['user_id' => $user->id];
                })
                )
            ->create();
    }
}
