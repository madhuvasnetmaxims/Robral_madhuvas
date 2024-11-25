<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $userId = session('login_true');
        
        if ($userId) {
            $product = Product::findOrFail($request->id);

            $cartItem = Cart::where('user_id', $userId)
                            ->where('product_id', $product->id)
                            ->first();

            if ($cartItem) {
                $cartItem->quantity += $request->quantity;
                $cartItem->save();
            } else {
                Cart::create([
                    'user_id' => $userId,
                    'product_id' => $product->id,
                    'quantity' => $request->quantity,
                ]);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Product added to cart successfully!',
            ]);
        } else {
            $cart = session()->get('cart', []);

            if (isset($cart[$request->id])) {
                $cart[$request->id]['quantity'] += $request->quantity;
            } else {
                $cart[$request->id] = [
                    'id' => $request->id,
                    'name' => $request->name,
                    'price' => $request->price,
                    'image' => $request->image,
                    'quantity' => $request->quantity,
                ];
            }

            session()->put('cart', $cart);

            return response()->json([
                'status' => 'success',
                'message' => 'Product added to cart successfully!',
                'cart' => $cart,
            ]);
        }
    }

    public function viewCart()
{
    $userId = session('login_true');
    
    if ($userId) {
        // If user is logged in, get the cart items from the database
        $cartItems = Cart::where('user_id', $userId)
                         ->with('product') // Ensure the 'product' relation is eager loaded
                         ->get();

        // Merge product data into the cart items (using 'product' relation)
        $cartItems = $cartItems->map(function ($cartItem) {
            $product = $cartItem->product; // Access the related product
            return [
                'id' => $cartItem->product_id,
                'product_id' => $cartItem->product_id,
                'quantity' => $cartItem->quantity,
                'image' => $product->image,
                'name' => $product->name,
                'price' => $product->price,
                'total_price' => $product->price * $cartItem->quantity,
            ];
        });

        // Calculate the total price of the cart
        $cartTotal = $cartItems->sum('total_price');

    } else {
        // If user is not logged in, get the cart from session (assuming cart is stored in session as an array)
        $cartItems = session('cart', []);
        
        // Calculate the total price of the cart
        $cartTotal = array_reduce($cartItems, function ($total, $item) {
            return $total + ($item['price'] * $item['quantity']);
        }, 0);
    }

    // Return the view with cart items and the total
    return view('cart', compact('cartItems', 'cartTotal'));
}


    public function update(Request $request, $id)
    {
        $userId = session('login_true');
        
        if ($userId) {
            $cartItem = Cart::where('user_id', $userId)
                            ->where('product_id', $id)
                            ->first();



            if ($cartItem) {
                $cartItem->quantity = $request->quantity;
                $cartItem->save();

                return response()->json([
                    'success' => true,
                    'message' => 'Cart updated successfully!',
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Product not found in cart.',
            ]);
        } else {
            $cart = session()->get('cart', []);

            if (isset($cart[$id])) {
                $cart[$id]['quantity'] = $request->quantity;
                session()->put('cart', $cart);

                return response()->json([
                    'success' => true,
                    'message' => 'Cart updated successfully!',
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Product not found in cart.',
            ]);
        }
    }

    public function remove($id)
    {
        $userId = session('login_true');
        
        if ($userId) {
            Cart::where('user_id', $userId)
                ->where('product_id', $id)
                ->delete();

            return redirect()->route('view.cart')->with('success', 'Item removed from cart.');
        } else {
            $cart = session()->get('cart', []);

            if (isset($cart[$id])) {
                unset($cart[$id]);
                session()->put('cart', $cart);
            }

            return redirect()->route('view.cart')->with('success', 'Item removed from cart.');
        }
    }
}
