<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->json('shipping_address')->nullable()->after('platform_fee');
            $table->json('billing_address')->nullable()->after('shipping_address');
            $table->decimal('shipping_fee', 10, 2)->default(0)->after('billing_address');
            $table->decimal('subtotal', 10, 2)->default(0)->after('shipping_fee');
            $table->decimal('discount_total', 10, 2)->default(0)->after('subtotal');
            $table->decimal('tax', 10, 2)->default(0)->after('discount_total');
            $table->string('tracking_number')->nullable()->after('tax');
            $table->text('notes')->nullable()->after('tracking_number');
            $table->date('estimated_delivery_date')->nullable()->after('notes');
            $table->string('payment_status')->default('pending')->after('estimated_delivery_date');
            $table->timestamp('paid_at')->nullable()->after('payment_status');
            $table->timestamp('shipped_at')->nullable()->after('paid_at');
            $table->timestamp('delivered_at')->nullable()->after('shipped_at');
            $table->timestamp('cancelled_at')->nullable()->after('delivered_at');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'shipping_address', 'billing_address', 'shipping_fee', 'subtotal',
                'discount_total', 'tax', 'tracking_number', 'notes',
                'estimated_delivery_date', 'payment_status', 'paid_at',
                'shipped_at', 'delivered_at', 'cancelled_at'
            ]);
        });
    }
};
