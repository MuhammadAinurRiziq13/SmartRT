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
        Schema::create('occupancy_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('house_id')
                ->constrained('houses')
                ->onDelete('cascade'); // <- ini penting
            $table->foreignId('resident_id')
                ->constrained('residents');
            $table->enum('occupancy_type', ['contract', 'permanent']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('occupancy_histories');
    }
};