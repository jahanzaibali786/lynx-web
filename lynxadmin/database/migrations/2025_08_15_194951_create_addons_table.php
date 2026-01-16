<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('addons', function (Blueprint $table) {
            $table->id();
            // $table->foreignId('category')->constrained('addoncategories');
            $table->integer('category');
            $table->string('name', 29)->nullable();
            $table->string('icon', 25)->nullable();
            $table->string('short_detail', 112)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addons');
    }
};
