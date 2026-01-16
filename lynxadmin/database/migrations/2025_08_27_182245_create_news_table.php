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
        // database/migrations/xxxx_xx_xx_create_news_table.php
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('image')->nullable();
            $table->text('excerpt')->nullable();
            $table->longText('description');
            $table->date('published_at')->nullable(); // optional
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news');
    }
};
