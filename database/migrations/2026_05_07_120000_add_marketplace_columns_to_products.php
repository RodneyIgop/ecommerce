<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('sku')->nullable()->after('name');
            $table->decimal('weight', 8, 2)->nullable()->after('stock');
            $table->string('dimensions')->nullable()->after('weight');
            $table->integer('moq')->default(1)->after('dimensions');
            $table->boolean('is_preorder')->default(false)->after('moq');
            $table->decimal('preorder_deposit_percent', 5, 2)->default(0)->after('is_preorder');
            $table->integer('estimated_production_days')->nullable()->after('preorder_deposit_percent');
            $table->decimal('shipping_base_rate', 10, 2)->default(0)->after('estimated_production_days');
            $table->decimal('shipping_weight_rate', 10, 2)->default(0)->after('shipping_base_rate');
            $table->decimal('shipping_handling_fee', 10, 2)->default(0)->after('shipping_weight_rate');
            $table->boolean('is_wholesale_enabled')->default(true)->after('shipping_handling_fee');
            $table->unsignedBigInteger('product_group_id')->nullable()->after('category_id');
            $table->index('product_group_id');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
                'sku', 'weight', 'dimensions', 'moq', 'is_preorder',
                'preorder_deposit_percent', 'estimated_production_days',
                'shipping_base_rate', 'shipping_weight_rate', 'shipping_handling_fee',
                'is_wholesale_enabled', 'product_group_id'
            ]);
        });
    }
};
