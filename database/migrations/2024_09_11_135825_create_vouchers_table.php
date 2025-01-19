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
        Schema::create('vouchers', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('discount');
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('quantity');
            $table->decimal('min_money', 10, 2);
            $table->decimal('max_money', 10, 2);
            $table->boolean('is_active')->default(true);
            $table->integer('points_required')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vouchers');
    }
};
