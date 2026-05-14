<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;

class CartController extends Controller
{
    public function index()
    {
        $cart = $this->getOrCreateCart();
        $cart->load('items.product.category');
        $cart->recalculate();

        return view('cart.index', compact('cart'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1|max:99',
        ]);

        $product = Product::findOrFail($request->product_id);
        $quantity = (int) $request->quantity;

        // Check if product is in stock
        if ($product->stock < $quantity) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Insufficient stock. Available: ' . $product->stock
                ], 400);
            }
            return back()->with('error', 'Insufficient stock. Available: ' . $product->stock);
        }

        $cart = $this->getOrCreateCart();

        // Check if product already exists in cart
        $existing = CartItem::where('cart_id', $cart->id)
            ->where('product_id', $product->id)
            ->first();

        if ($existing) {
            // Update quantity instead of creating new entry
            $newQuantity = $existing->quantity + $quantity;
            
            if ($product->stock < $newQuantity) {
                if ($request->expectsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Insufficient stock. Available: ' . $product->stock
                    ], 400);
                }
                return back()->with('error', 'Insufficient stock. Available: ' . $product->stock);
            }

            $existing->update([
                'quantity' => $newQuantity,
                'unit_price' => $product->retail_price,
            ]);
        } else {
            // Create new cart item
            CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $product->id,
                'quantity' => $quantity,
                'unit_price' => $product->retail_price,
                'discount_amount' => 0,
                'shipping_estimate' => 0,
                'type' => 'retail',
            ]);
        }

        $cart->recalculate();

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Added to cart successfully',
                'cart_count' => $cart->items->sum('quantity'),
                'cart_total' => number_format($cart->total, 2)
            ]);
        }

        return back()->with('success', 'Added to cart.');
    }

    public function update(Request $request, CartItem $item)
    {
        $request->validate(['quantity' => 'required|integer|min:1|max:99']);

        $product = $item->product;
        $quantity = (int) $request->quantity;

        if ($product->stock < $quantity) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Insufficient stock. Available: ' . $product->stock
                ], 400);
            }
            return back()->with('error', 'Insufficient stock. Available: ' . $product->stock);
        }

        $item->update([
            'quantity' => $quantity,
            'unit_price' => $product->retail_price,
        ]);

        $item->cart->recalculate();

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Cart updated successfully',
                'cart_count' => $item->cart->items->sum('quantity'),
                'cart_total' => number_format($item->cart->total, 2),
                'item_total' => number_format($item->quantity * $item->unit_price, 2)
            ]);
        }

        return back()->with('success', 'Cart updated.');
    }

    public function remove(CartItem $item)
    {
        $cart = $item->cart;
        $item->delete();
        $cart->recalculate();

        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Item removed from cart',
                'cart_count' => $cart->items->sum('quantity'),
                'cart_total' => number_format($cart->total, 2)
            ]);
        }

        return back()->with('success', 'Item removed from cart.');
    }

    public function clear()
    {
        $cart = $this->getOrCreateCart();
        $cart->items()->delete();
        $cart->recalculate();

        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Cart cleared',
                'cart_count' => 0,
                'cart_total' => '0.00'
            ]);
        }

        return back()->with('success', 'Cart cleared.');
    }

    public function getCount()
    {
        $cart = $this->getOrCreateCart();
        return response()->json([
            'count' => $cart->items->sum('quantity')
        ]);
    }

    private function getOrCreateCart(): Cart
    {
        return Cart::firstOrCreate(
            ['user_id' => auth()->id()],
            ['type' => 'retail', 'total' => 0, 'discount_total' => 0, 'shipping_total' => 0]
        );
    }
}
