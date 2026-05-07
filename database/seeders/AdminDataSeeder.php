<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Setting;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Dispute;

class AdminDataSeeder extends Seeder
{
    public function run(): void
    {
        // Categories
        $categories = [
            ['name' => 'Shirts', 'slug' => 'shirts'],
            ['name' => 'Pants', 'slug' => 'pants'],
            ['name' => 'Jackets', 'slug' => 'jackets'],
            ['name' => 'Accessories', 'slug' => 'accessories'],
        ];
        foreach ($categories as $cat) {
            Category::firstOrCreate(['slug' => $cat['slug']], $cat);
        }

        // Settings
        Setting::firstOrCreate(['key' => 'commission_rate'], ['value' => '10']);
        Setting::firstOrCreate(['key' => 'platform_fee'], ['value' => '2.50']);
        Setting::firstOrCreate(['key' => 'free_shipping_threshold'], ['value' => '75']);
        Setting::firstOrCreate(['key' => 'solo_buyer_max'], ['value' => '3']);
        Setting::firstOrCreate(['key' => 'currency'], ['value' => 'USD']);

        // Products (seeded for the existing business user)
        $business = \App\Models\User::where('role', \App\Models\User::ROLE_BUSINESS)->first();
        if ($business) {
            Product::firstOrCreate(['name' => 'Classic Cotton Tee', 'business_id' => $business->id], [
                'category_id' => 1,
                'description' => 'Premium cotton t-shirt, essential for every wardrobe.',
                'retail_price' => 29.99,
                'wholesale_price' => 18.00,
                'stock' => 120,
                'status' => 'active',
            ]);
            Product::firstOrCreate(['name' => 'Slim Fit Chinos', 'business_id' => $business->id], [
                'category_id' => 2,
                'description' => 'Versatile chinos for work and weekend.',
                'retail_price' => 59.99,
                'wholesale_price' => 35.00,
                'stock' => 80,
                'status' => 'active',
            ]);
            Product::firstOrCreate(['name' => 'Lightweight Jacket', 'business_id' => $business->id], [
                'category_id' => 3,
                'description' => 'Water-resistant shell jacket.',
                'retail_price' => 89.99,
                'wholesale_price' => 55.00,
                'stock' => 45,
                'status' => 'active',
            ]);
            Product::firstOrCreate(['name' => 'Premium Polo', 'business_id' => $business->id], [
                'category_id' => 1,
                'description' => 'Soft-touch polo shirt.',
                'retail_price' => 39.99,
                'wholesale_price' => 22.00,
                'stock' => 0,
                'status' => 'active',
            ]);
        }

        // Update existing products with marketplace fields if not already set
        Product::where('business_id', $business->id)->whereNull('sku')->update([
            'sku' => \DB::raw("CONCAT('SKU-', id, '-', FLOOR(RAND() * 10000))"),
            'weight' => \DB::raw("ROUND(RAND() * 2 + 0.2, 2)"),
            'dimensions' => '30x20x5 cm',
            'moq' => 10,
            'shipping_base_rate' => 5.00,
            'shipping_weight_rate' => 2.50,
            'shipping_handling_fee' => 1.00,
            'is_wholesale_enabled' => true,
        ]);

        Product::where('stock', 0)->where('business_id', $business->id)->update([
            'is_preorder' => true,
            'preorder_deposit_percent' => 25,
            'estimated_production_days' => 14,
        ]);

        // Sample Orders
        $buyer = \App\Models\User::where('role', \App\Models\User::ROLE_BUYER)->first();
        if ($business && $buyer && Order::count() === 0) {
            $order1 = Order::create([
                'buyer_id' => $buyer->id,
                'business_id' => $business->id,
                'type' => 'retail',
                'status' => 'delivered',
                'total' => 89.98,
                'commission' => 8.99,
                'platform_fee' => 2.50,
            ]);
            OrderItem::create(['order_id' => $order1->id, 'product_id' => 1, 'quantity' => 2, 'price' => 29.99]);
            OrderItem::create(['order_id' => $order1->id, 'product_id' => 2, 'quantity' => 1, 'price' => 59.99]);

            $order2 = Order::create([
                'buyer_id' => $buyer->id,
                'business_id' => $business->id,
                'type' => 'b2b',
                'status' => 'processing',
                'total' => 540.00,
                'commission' => 54.00,
                'platform_fee' => 5.00,
            ]);
            OrderItem::create(['order_id' => $order2->id, 'product_id' => 1, 'quantity' => 20, 'price' => 18.00]);
            OrderItem::create(['order_id' => $order2->id, 'product_id' => 2, 'quantity' => 10, 'price' => 35.00]);

            // Dispute
            Dispute::firstOrCreate(['order_id' => $order1->id, 'user_id' => $buyer->id], [
                'business_id' => $business->id,
                'type' => 'refund',
                'status' => 'open',
                'description' => 'Product arrived with a small tear on the seam.',
            ]);
        }
    }
}
