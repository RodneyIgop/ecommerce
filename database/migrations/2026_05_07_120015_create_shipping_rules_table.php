<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('shipping_rules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('business_id')->constrained('users')->onDelete('cascade');
            $table->string('name');
            $table->string('type')->default('local');
            $table->decimal('base_rate', 10, 2)->default(0);
            $table->decimal('weight_rate', 10, 2)->default(0);
            $table->decimal('distance_rate', 10, 2)->default(0);
            $table->decimal('handling_fee', 10, 2)->default(0);
            $table->decimal('min_weight', 8, 2)->nullable();
            $table->decimal('max_weight', 8, 2)->nullable();
            $table->json('regions')->nullable();
            $table->json('couriers')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shipping_rules');
    }
};
