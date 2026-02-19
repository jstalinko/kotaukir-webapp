<?php

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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->integer('category_id');
            $table->string('title');
            $table->string('slug')->unique();
            $table->json('images')->default(json_encode(['https://placehold.co/600x400/8d6e63/FFFFFF?text=NO+IMAGE']));
            $table->json('tags');
            $table->integer('views')->default(0);
            $table->integer('clicks')->default(0);
            $table->text('content');
            $table->boolean('is_published')->default(true);
            $table->dateTime('published_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
