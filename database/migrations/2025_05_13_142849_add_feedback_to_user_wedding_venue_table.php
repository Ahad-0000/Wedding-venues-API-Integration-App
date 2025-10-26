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
        Schema::table('user_wedding_venue', function (Blueprint $table) {
            $table->text('feedback')->nullable();
            $table->tinyInteger('rating')->nullable();        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_wedding_venue', function (Blueprint $table) {
            $table->dropColumn('feedback');
            $table->dropColumn('rating');
        });
    }
};
