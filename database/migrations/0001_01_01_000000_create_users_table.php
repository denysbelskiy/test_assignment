<?php

use App\Models\Position;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('positions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone');
            $table->foreignIdFor(Position::class)->constrained();
            $table->timestamps();
        });

        Schema::create('user_photos', function (Blueprint $table) {
            $table->id();
            $table->string('original_name');
            $table->string('path_to_original');
            $table->string('path');
            $table->foreignIdFor(User::class)->constrained()->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('tokens', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->timestamp('expires_at');
            $table->boolean('used')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('positions');
        Schema::dropIfExists('users');
        Schema::dropIfExists('user_photos');
        Schema::dropIfExists('tokens');
    }
};
