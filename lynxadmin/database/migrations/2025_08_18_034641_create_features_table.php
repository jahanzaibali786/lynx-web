<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('features', function (Blueprint $table) {
            $table->id();
            $table->foreignId('card_id')
                ->constrained('product_cards')
                ->onDelete('cascade'); // if card deleted → delete its features
            $table->string('feature_icon', 50);
            $table->string('feature_heading', 150);
            $table->text('feature_paragraph');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('features');
    }
};
