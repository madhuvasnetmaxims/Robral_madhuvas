<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{

public function index(Request $request)
{
    $searchQuery = $request->input('search');

    $products = Product::when($searchQuery, function ($query, $searchQuery) {
        return $query->where('name', 'LIKE', "%{$searchQuery}%")
                     ->orWhere('description', 'LIKE', "%{$searchQuery}%");
    })->get();

    if (session('login_true')) {
        $userId = session('login_true');
        $cartProductIds = Cart::where('user_id', $userId)->pluck('product_id')->toArray();
    } else {
        $cartProductIds = array_keys(session('cart', []));
    }

    return view('index', compact('products', 'cartProductIds', 'searchQuery'));
}


}
