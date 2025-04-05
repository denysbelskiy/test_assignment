<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class CustomFakerImageService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function fetchAndStoreImage()
    {
        $response = Http::get('https://thispersondoesnotexist.com/');

        if ($response->successful()) {
            $fileName = uniqid() . '.jpeg';
            $filePath = "images/users/original/$fileName";

            Storage::disk('public')->put($filePath, $response->body());

            return $filePath;
        }

        return null;
    }
}
