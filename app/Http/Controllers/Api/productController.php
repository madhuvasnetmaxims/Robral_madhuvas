<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Repository\ProductRepo;
use App\Http\Requests\ProductReqest;
use App\Http\Requests\ProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;

class productController extends Controller
{
     /**
     * Display a listing of all products.
     */
    public function index(Request $request)
{
    $perPage = $request->input('per_page', 10);

    $products = ProductRepo::getProducts($perPage);

    if(count($products)>0){

        return response()->json([
            'status' => true,
            'message' => 'Products retrieved successfully',
            'data' => $products
        ]);

    }else{
        return response()->json(["data"=>[],"status"=>false,"message"=>"products not available"]);
    }

   
}


    /**
     * Store a newly created product in storage.
     */
    public function store(Request $request)
    {
        $validProduct = ProductRequest::createProduct($request);

        if ($validProduct === true) {
            $product = ProductRepo::createProduct($request);
            if($product){
              return response()->json(['data' => $product, 'status' => true, 'message' => 'Product created successfully'], 201);
            }else{
                return response()->json(["data"=> [], "status"=> false,"message"=>"something went wrong"],422);
            }

        }else{
            return response()->json(["status"=> false,"message"=>$validProduct],422);
        }


    }

    /**
     * updating the specified product.
     */

    public function updateProduct(Request $request)
    {
        $validProduct = ProductRequest::updateProduct($request);

        if ($validProduct === true) {
            $product = ProductRepo::updateProduct($request, $request->product_id);
            if($product){
              return response()->json(['data' => $product, 'status' => true, 'message' => 'Product updated successfully'], 201);
            }else{
                return response()->json(["data"=> [], "status"=> false,"message"=>"something went wrong"],422);
            }

        }else{
            return response()->json(["status"=> false,"message"=>$validProduct],422);
        }


    }

    /**
     * Display the specified product.
     */
    public function show($id)
    {
        $product = ProductRepo::findProduct($id);

        if (!$product) {
            return response()->json(['data' => [], 'status' => false, 'message' => 'Product not found'], 404);
        }

        return response()->json(['data' => $product, 'status' => true, 'message' => 'Product retrieved successfully'], 200);
    }

   

    /**
     * Remove the specified product from storage.
     */
    public function destroy($id)
    {
        $product = ProductRepo::deleteProduct($id);

        if (!$product) {
            return response()->json(['data' => [], 'status' => false, 'message' => 'Product not found'], 404);
        }

        return response()->json([ 'status' => true, 'message' => 'Product deleted successfully'], 200);
    }

    public function search(Request $request)
{
    $query = $request->input('query', ''); 

    if (empty($query)) {
        return response()->json([
            'status' => false,
            'message' => 'Search query cannot be empty',
            'data' => []
        ], 422);
    }

    $products = ProductRepo::searchProductsByName($query);

    if ($products->isEmpty()) {
        return response()->json([
            'status' => false,
            'message' => 'No products found matching the query',
            'data' => []
        ], 404);
    }

    return response()->json([
        'status' => true,
        'message' => 'Products retrieved successfully',
        'data' => $products
    ]);
}

}
