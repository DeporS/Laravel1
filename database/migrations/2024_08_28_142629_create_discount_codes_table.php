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
        Schema::create('discount_codes', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->decimal('price_multiply', 5, 2);
            $table->decimal('min_cart_value', 10, 2)->nullable();
            $table->timestamp('start_date')->nullable();
            $table->timestamp('expiration_date')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->integer('usage_limit')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('discount_codes');
    }
};
