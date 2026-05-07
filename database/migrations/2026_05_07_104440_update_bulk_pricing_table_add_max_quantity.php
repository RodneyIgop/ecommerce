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
        Schema::table('bulk_pricing', function (Blueprint $table) {
            $table->integer('max_quantity')->nullable()->after('min_quantity');
            $table->dropColumn('discount_percentage');
            $table->dropColumn('price_per_unit');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bulk_pricing', function (Blueprint $table) {
            $table->dropColumn('max_quantity');
            $table->decimal('discount_percentage', 5, 2)->after('min_quantity');
            $table->decimal('price_per_unit', 10, 2)->after('discount_percentage');
        });
    }
};
