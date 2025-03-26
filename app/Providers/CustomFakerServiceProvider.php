<?php

namespace App\Providers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\ServiceProvider;

class CustomFakerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton('image.service', function () {
            return new class {
                public function fetchAndStoreImage()
                {
                    $response = Http::get('https://thispersondoesnotexist.com/');

                    if ($response->successful()) {
                        // Generate a unique filename
                        $fileName = uniqid() . '.jpeg';
                        $filePath = "images/users/$fileName";

                        Storage::disk('public')->put($filePath, $response->body());

                        return $filePath;
                    }

                    return null;
                }
            };
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
