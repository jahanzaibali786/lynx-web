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
        Schema::create('admission_applications', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('phone');
            $table->string('address');
            $table->string('child_name');
            $table->enum('gender', ['Male', 'Female']);
            $table->text('more_about_child')->nullable();
            $table->string('branch');
            $table->string('class');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admission_applications');
    }
};
