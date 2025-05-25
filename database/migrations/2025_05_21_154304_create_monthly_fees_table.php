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
        Schema::create('monthly_fees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('house_id')->constrained('houses');
            $table->foreignId('resident_id')->constrained('residents');
            $table->tinyInteger('month');
            $table->year('year');
            $table->decimal('security_fee', 10, 2)->default(100000);
            $table->decimal('cleaning_fee', 10, 2)->default(15000);
            $table->enum('security_status', ['paid', 'unpaid'])->default('unpaid');
            $table->enum('cleaning_status', ['paid', 'unpaid'])->default('unpaid');
            $table->date('payment_date')->nullable();
            $table->enum('payment_method', ['cash', 'transfer'])->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->unique(['house_id', 'month', 'year']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('monthly_fees');
    }
};