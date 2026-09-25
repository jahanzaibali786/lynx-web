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
        Schema::table('career_opportunities', function (Blueprint $table) {
            $table->longText('full_description')->nullable()->after('short_description');
            // Keep detail_pdf as optional for backward compatibility
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('career_opportunities', function (Blueprint $table) {
            $table->dropColumn('full_description');
        });
    }
};
