<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Services\DiscountEngine;
use App\Services\ShippingCalculator;

class CartController extends Controller
{
    public function index()
    {
        $cart = $this->getOrCreateCart();
        $cart->load('items.product.business.businessProfile', 'items.variant');
        $cart->recalculate();

        return view('cart.index', compact('cart'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'variant_id' => 'nullable|exists:product_variants,id',
            'quantity' => 'required|integer|min:1',
            'type' => 'required|in:retail,wholesale',
        ]);

        $product = Product::findOrFail($request->product_id);
        $quantity = (int) $request->quantity;
        $type = $request->type;

        if ($type === 'wholesale' && !$product->is_wholesale_enabled) {
            return back()->with('error', 'Wholesale not available for this product.');
        }

        if (!DiscountEngine::validateMoq($product, $quantity, $type)) {
            return back()->with('error', 'Minimum order quantity not met. MOQ: ' . $product->moq);
        }

        $available = $product->getAvailableStock();
        if ($available < $quantity) {
            if ($product->is_preorder) {
                return redirect()->route('preorder.create', ['product' => $product->id])
                    ->with('info', 'Item is available for preorder.');
            }
            return back()->with('error', 'Insufficient stock. Available: ' . $available);
        }

        $calc = DiscountEngine::calculate($product, $quantity, $type);
        $shipping = ShippingCalculator::calculateForProduct($product, $product->weight ?? 0.5);

        $cart = $this->getOrCreateCart();
        $cart->type = $type;
        $cart->save();

        $existing = CartItem::where('cart_id', $cart->id)
            ->where('product_id', $product->id)
            ->where('variant_id', $request->variant_id)
            ->first();

        if ($existing) {
            $newQty = $existing->quantity + $quantity;
            $newCalc = DiscountEngine::calculate($product, $newQty, $type);
            $existing->update([
                'quantity' => $newQty,
                'unit_price' => $newCalc['unit_price'],
                'discount_amount' => $newCalc['discount_amount'],
                'shipping_estimate' => ShippingCalculator::calculateForProduct($product, ($product->weight ?? 0.5) * $newQty),
            ]);
        } else {
            CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $product->id,
                'variant_id' => $request->variant_id,
                'quantity' => $quantity,
                'unit_price' => $calc['unit_price'],
                'discount_amount' => $calc['discount_amount'],
                'shipping_estimate' => $shipping,
                'type' => $type,
            ]);
        }

        $cart->recalculate();

        return back()->with('success', 'Added to cart.');
    }

    public function update(Request $request, CartItem $item)
    {
        $request->validate(['quantity' => 'required|integer|min:1']);

        $product = $item->product;
        $quantity = (int) $request->quantity;

        if (!DiscountEngine::validateMoq($product, $quantity, $item->type)) {
            return back()->with('error', 'MOQ not met.');
        }

        $available = $product->getAvailableStock();
        if ($available < $quantity) {
            return back()->with('error', 'Insufficient stock.');
        }

        $calc = DiscountEngine::calculate($product, $quantity, $item->type);
        $item->update([
            'quantity' => $quantity,
            'unit_price' => $calc['unit_price'],
            'discount_amount' => $calc['discount_amount'],
            'shipping_estimate' => ShippingCalculator::calculateForProduct($product, ($product->weight ?? 0.5) * $quantity),
        ]);

        $item->cart->recalculate();

        return back()->with('success', 'Cart updated.');
    }

    public function remove(CartItem $item)
    {
        $cart = $item->cart;
        $item->delete();
        $cart->recalculate();

        return back()->with('success', 'Item removed from cart.');
    }

    public function clear()
    {
        $cart = $this->getOrCreateCart();
        $cart->items()->delete();
        $cart->recalculate();

        return back()->with('success', 'Cart cleared.');
    }

    private function getOrCreateCart(): Cart
    {
        return Cart::firstOrCreate(
            ['user_id' => auth()->id()],
            ['type' => 'retail', 'total' => 0, 'discount_total' => 0, 'shipping_total' => 0]
        );
    }
}
