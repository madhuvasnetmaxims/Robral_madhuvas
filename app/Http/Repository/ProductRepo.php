<?php

namespace App\Http\Repository;

use App\Models\Product;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Http\FormRequest;

class ProductRepo extends FormRequest
{

    public static function getProducts($perPage = 10)
{
    $products = Product::orderBy('created_at', 'desc')->paginate($perPage);
    return $products;
}


  public static function createProduct($request){

    if ($request->hasFile("image")) {
        $file = $request->file("image");
        $destinationPath = 'productImages'; 
        $fileName = time() . '_' . rand(1, 50) . '.' . $file->getClientOriginalExtension();
        $file->move(public_path($destinationPath), $fileName);
        $imagePath = url($destinationPath . '/' . $fileName);
    }
    
    $product = Product ::create([
        "name"=> $request->name,
        "description"=> $request->description,
        "price"=> $request->price,
        "image"=> $imagePath
    ]) ;
    if($product){
        return $product;
    }else{
        return false;
    }
  }

  public static function updateProduct($request, $productId)
  {
      $product = Product::find($productId);
  
      if (!$product) {
          return false; 
      }
  
      $updateData = [];
  
      if ($request->has('name')) {
          $updateData['name'] = $request->name;
      }
  
      if ($request->has('description')) {
          $updateData['description'] = $request->description;
      }
  
      if ($request->has('price')) {
          $updateData['price'] = $request->price;
      }
  
      if ($request->hasFile("image")) {
          $file = $request->file("image");
          $destinationPath = 'productImages'; 
          $fileName = time() . '_' . rand(1, 50) . '.' . $file->getClientOriginalExtension();
          $file->move(public_path($destinationPath), $fileName);
          $imagePath = url($destinationPath . '/' . $fileName);
  
          if ($product->image) {
              $oldImagePath = public_path(parse_url($product->image, PHP_URL_PATH));
              if (file_exists($oldImagePath)) {
                  unlink($oldImagePath);
              }
          }
  
          $updateData['image'] = $imagePath;
      }
  
      $isUpdated = $product->update($updateData);
  
      if ($isUpdated) {
          return $product;
      } else {
          return false;
      }
  }

  public static function deleteProduct($productId)
{
    $product = Product::find($productId);

    if (!$product) {
        return false; 
    }

    if ($product->image) {
        $imagePath = public_path(parse_url($product->image, PHP_URL_PATH));
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }
    }

    $isDeleted = $product->delete();

    return $isDeleted;
}


public static function searchProductsByName($query)
{
    $products = Product::where('name', 'LIKE', '%' . $query . '%')
    ->orWhere('description', 'LIKE', '%' . $query . '%')
    ->orWhere('price', 'LIKE', '%' . $query . '%')
    ->orderBy('created_at', 'desc')
    ->get();


    return $products;
}

public static function findProduct($id){
    $product = Product::where("id",$id)->first();
    if($product){
        return $product;
    }else{
        return null;
    }
  }

  

 
   
}
