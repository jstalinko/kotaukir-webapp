<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('site_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('email');
            $table->text('message');
            $table->timestamps();
        });

        // Also fix site_logo column size if it's still a string
        Schema::table('sites', function (Blueprint $table) {
            $table->string('site_logo', 2048)->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};
