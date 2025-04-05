<?php

namespace Database\Factories;

use App\Models\User;
use App\Services\CustomFakerImageService;
use App\Services\ImageOptimizationService;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserPhoto>
 */
class UserPhotoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $originalPhotoPath = (new CustomFakerImageService)->fetchAndStoreImage();
        $optimizedPhotoPath = (new ImageOptimizationService())->optimizeAndResize($originalPhotoPath);
        return [
            'original_name' => 'download.jpeg',
            'path_to_original' => $originalPhotoPath,
            'path' => $optimizedPhotoPath,
            'user_id' => User::firstOrCreate(),
        ];
    }
}
