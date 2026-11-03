<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->cascadeOnDelete();
            $table->string('slug', 140)->unique();
            $table->string('headline', 150)->nullable();
            $table->text('bio')->nullable();
            $table->string('carrera', 120)->nullable()->index();
            $table->string('sede', 60)->nullable();
            $table->unsignedTinyInteger('ciclo')->nullable();
            $table->string('github_url')->nullable();
            $table->string('linkedin_url')->nullable();
            $table->string('website_url')->nullable();
            $table->string('photo_path')->nullable();
            $table->boolean('is_public')->default(true)->index();
            $table->boolean('available')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
