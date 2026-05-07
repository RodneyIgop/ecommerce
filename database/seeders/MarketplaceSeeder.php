<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Product;
use App\Models\DiscountTier;
use App\Models\ShippingRule;
use App\Models\ProductVariant;
use App\Models\ProductGroup;
use App\Models\Wallet;

class MarketplaceSeeder extends Seeder
{
    public function run(): void
    {
        $business = User::where('role', User::ROLE_BUSINESS)->first();
        if (!$business) return;

        // Ensure categories exist
        $shirts = \App\Models\Category::firstOrCreate(['slug' => 'shirts'], ['name' => 'Shirts']);
        $pants = \App\Models\Category::firstOrCreate(['slug' => 'pants'], ['name' => 'Pants']);

        // Create wallet for business
        Wallet::firstOrCreate(
            ['user_id' => $business->id],
            ['balance' => 0, 'currency' => 'USD']
        );

        // Create wallets for all users
        foreach (User::all() as $user) {
            Wallet::firstOrCreate(
                ['user_id' => $user->id],
                ['balance' => 0, 'currency' => 'USD']
            );
        }

        // Update existing products with marketplace fields
        Product::where('business_id', $business->id)->update([
            'sku' => \DB::raw("CONCAT('SKU-', id, '-', FLOOR(RAND() * 10000))"),
            'weight' => \DB::raw("ROUND(RAND() * 2 + 0.2, 2)"),
            'dimensions' => '30x20x5 cm',
            'moq' => 10,
            'is_preorder' => false,
            'preorder_deposit_percent' => 0,
            'estimated_production_days' => null,
            'shipping_base_rate' => 5.00,
            'shipping_weight_rate' => 2.50,
            'shipping_handling_fee' => 1.00,
            'is_wholesale_enabled' => true,
        ]);

        // Enable preorder on the out-of-stock product
        Product::where('stock', 0)->where('business_id', $business->id)->update([
            'is_preorder' => true,
            'preorder_deposit_percent' => 25,
            'estimated_production_days' => 14,
        ]);

        // Create discount tiers for the business
        $products = Product::where('business_id', $business->id)->get();
        foreach ($products as $product) {
            DiscountTier::firstOrCreate(
                ['business_id' => $business->id, 'product_id' => $product->id, 'min_quantity' => 1],
                ['max_quantity' => 49, 'discount_percent' => 0, 'is_active' => true]
            );
            DiscountTier::firstOrCreate(
                ['business_id' => $business->id, 'product_id' => $product->id, 'min_quantity' => 50],
                ['max_quantity' => 99, 'discount_percent' => 10, 'is_active' => true]
            );
            DiscountTier::firstOrCreate(
                ['business_id' => $business->id, 'product_id' => $product->id, 'min_quantity' => 100],
                ['max_quantity' => 499, 'discount_percent' => 20, 'is_active' => true]
            );
            DiscountTier::firstOrCreate(
                ['business_id' => $business->id, 'product_id' => $product->id, 'min_quantity' => 500],
                ['max_quantity' => null, 'discount_percent' => 35, 'is_active' => true]
            );
        }

        // Create a business-wide discount tier
        DiscountTier::firstOrCreate(
            ['business_id' => $business->id, 'product_id' => null, 'min_quantity' => 1000],
            ['max_quantity' => null, 'discount_percent' => 40, 'is_active' => true]
        );

        // Create shipping rules
        ShippingRule::firstOrCreate(
            ['business_id' => $business->id, 'name' => 'Standard Local'],
            [
                'type' => 'local',
                'base_rate' => 5.00,
                'weight_rate' => 2.50,
                'distance_rate' => 0.50,
                'handling_fee' => 1.00,
                'couriers' => ['Local Courier', 'FastShip'],
                'is_active' => true,
            ]
        );

        ShippingRule::firstOrCreate(
            ['business_id' => $business->id, 'name' => 'International Express'],
            [
                'type' => 'international',
                'base_rate' => 25.00,
                'weight_rate' => 8.00,
                'distance_rate' => 2.00,
                'handling_fee' => 5.00,
                'couriers' => ['DHL', 'FedEx'],
                'is_active' => true,
            ]
        );

        // Create product variants
        foreach ($products as $product) {
            $colors = ['Black', 'White', 'Navy', 'Gray'];
            $sizes = ['S', 'M', 'L', 'XL'];
            $i = 0;
            foreach ($colors as $color) {
                foreach ($sizes as $size) {
                    ProductVariant::firstOrCreate(
                        ['product_id' => $product->id, 'name' => "{$color} / {$size}"],
                        [
                            'sku' => $product->sku . '-' . strtoupper(substr($color, 0, 1)) . $size,
                            'attributes' => ['color' => $color, 'size' => $size],
                        ]
                    );
                    $i++;
                    if ($i >= 4) break 2;
                }
            }
        }

        // Create product groups for linking similar products across vendors
        ProductGroup::firstOrCreate(
            ['slug' => 't-shirts'],
            ['name' => 'T-Shirts', 'description' => 'All t-shirt styles', 'category_id' => $shirts->id]
        );
        ProductGroup::firstOrCreate(
            ['slug' => 'bottoms'],
            ['name' => 'Bottoms', 'description' => 'Pants and shorts', 'category_id' => $pants->id]
        );
    }
}
