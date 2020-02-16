<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use App\Http\Requests\AddToCartRequest;
use App\Models\Product;

class CartController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function show(Cart $cart)
    {
        return view('public.users.cart.show', compact('cart'));
    }

    /**
     * Add item to cart
     **/
    public function add(AddToCartRequest $request, Cart $cart)
    {
        $data = $request->validated();
        $product = Product::find($data['product_key']);
        
        $cart->add($product, $data['products_count'], $data['options']);
        $cart->save();
        
        return $data;
    }
}
