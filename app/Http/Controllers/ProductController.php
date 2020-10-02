<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
// use Gloudemans\Shoppingcart\Facades\Cart;

class ProductController extends Controller
{
    //
     public function index()
     {
         # code...
         //dd(Cart::content());

         if(request()->categorie)
         {
            $products = Product::with('categories')->whereHas('categories',function($q){
                $q->where('slug',request()->categorie);
            })->orderBy('created_at','DESC')->paginate(6);
         }else{
         $products = Product::with('categories')->orderBy('created_at','DESC')->paginate(6);
         }
         return  view('products.index')->with('products',$products);
     }

     public function show($slug)
     {
         # code...
         $product = Product::where('slug',$slug)->firstOrFail();
         return view('products.show')->with('product',$product);

     }
}
