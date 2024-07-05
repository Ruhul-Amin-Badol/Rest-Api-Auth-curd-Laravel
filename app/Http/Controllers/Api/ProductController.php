<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController as BaseController;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;

class ProductController extends BaseController
{
  public function index(){
    $products = Product::all();
    return $this->SentResponse(ProductResource::collection($products),'Product Retrived');
    
  }


  public function store(Request $request){
    $validator=Validator($request->all(),[
        'name' => 'required|string|max:255',
        'details' => 'required|string',
    ]);

    if($validator->fails()){
        return $this->SendError('Validation Error',$validator->errors());
    }
    $product=Product::create($request->all());
    return $this->SentResponse(new ProductResource($product),'Product Create Succeccfully');
  }

  public function show($id){
    $product=Product::find($id);
    if(is_null($product)){
      return $this->SendError('Product Not Found');
    }
    return $this->SentResponse(new ProductResource($product),'Product retrived');
  }

  public function update(Request $request, Product $product){
    $validator=Validator($request->all(),[
      'name' => 'required|string|max:255',
      'details' => 'required|string',
  ]);

  if($validator->fails()){
      return $this->SendError('Validation Error',$validator->errors());
  }
  $product->update($request->all());
  return $this->SentResponse(new ProductResource($product),'Product update successfully');
  }

  public function destroy(Product $product){
   $product->delete();
   return $this->SentResponse(new ProductResource($product),'Product Delete successfully');
  }

}
