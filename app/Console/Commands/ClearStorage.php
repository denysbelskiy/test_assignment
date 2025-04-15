<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class ClearStorage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:clear-storage';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Erase all images in the storage public folder';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $dir = 'images';
        if(Storage::disk('public')->exists($dir)){
            Storage::disk('public')->deleteDirectory($dir);
            $this->info("Folder '$dir' has been deleted.");
        }else{
            $this->warn("Folder '$dir' does not exist.");
        }
    }
}
