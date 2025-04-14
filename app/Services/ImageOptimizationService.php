<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Tinify\Exception;
use Tinify\Source;
use Tinify\Tinify;

class ImageOptimizationService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        Tinify::setKey(config('services.tinify.key'));
    }

    public function optimizeAndResize($path, $width = 70, $height = 70)
    {
        try {
            $file = Storage::disk('public')->get($path);
            $newfile = Source::fromBuffer($file);
            $resized = $newfile->resize([
                'method' => 'cover',
                'width' => $width,
                'height' => $height,
            ]);

            $comp = $resized->toBuffer();

            if ($comp) {
                $fileName = uniqid().'.jpeg';
                $newPath = 'images/users/'.$fileName;
                Storage::disk('public')->put($newPath, $comp);

                return $newPath;
            }

            return null;
        } catch (Exception $e) {
            throw new Exception('Image optimization failed: '.$e->getMessage());
        }
    }
}
