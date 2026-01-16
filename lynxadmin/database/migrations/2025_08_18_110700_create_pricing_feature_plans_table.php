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
        Schema::create('pricing_feature_plan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pricing_plan_id')->constrained('pricing_plans')->cascadeOnDelete();
            $table->foreignId('pricing_feature_id')->constrained('pricing_features')->cascadeOnDelete();
            $table->boolean('is_enabled')->default(true);
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pricing_feature_plans');
    }
};
