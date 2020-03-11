<?php

namespace App\Http\Controllers\Api;

use App\Models\Cart;
use Illuminate\Http\Request;
use App\Http\Requests\AddToCartRequest;
use App\Http\Requests\RemoveCartItemRequest;
use App\Models\Product;
use App\Http\Controllers\Controller;
use App\Http\Resources\CartResource;

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
        return new CartResource($cart);
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

    /**
     * Remove item from cart
     **/
    public function remove(RemoveCartItemRequest $request, Cart $cart)
    {
        $key = $request->validated()['product_key'];

        $cart->removeItem($key);
        $cart->save();

        return [
            'message' => 'Item successfully removed.',   
        ];
    }
}
