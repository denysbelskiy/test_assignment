<?php

namespace Database\Factories;

use App\Models\Position;
use Illuminate\Support\Facades\App;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->freeEmail(),
            'phone' => fake()->regexify('^\380[3-9][0-9]{8}$'),
            'photo' => App::make('image.service')->fetchAndStoreImage(),
            'position_id' => Position::inRandomOrder()->first()->id,
        ];
    }
}