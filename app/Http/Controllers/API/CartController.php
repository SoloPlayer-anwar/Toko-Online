<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormmater;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function storeCart (Request $request)
    {
        $request->validate([
            'name_product_cart' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id',
            'total_price_cart' => 'required|numeric',
            'status_cart' => 'sometimes',
            'quantity_cart' => 'required|numeric',
            'variant_cart' => 'required|string|max:255',
            'size_cart' => 'required|string|max:255',
            'category_cart' => 'sometimes',
            'image_cart' => 'sometimes'
        ]);


        $cart = Cart::create([
            'name_product_cart' => $request->name_product_cart,
            'user_id' => $request->user_id,
            'total_price_cart' => $request->total_price_cart,
            'status_cart' => $request->status_cart,
            'quantity_cart' => $request->quantity_cart,
            'variant_cart' => $request->variant_cart,
            'size_cart' => $request->size_cart,
            'category_cart' => $request->category_cart,
            'image_cart' => $request->image_cart,
        ]);


        try {
            $cart->save();
            return ResponseFormmater::success(
                $cart,
                'Success add cart'
            );
        }

        catch (\Exception $e) {
            return ResponseFormmater::error(
                null,
                $e->getMessage(),
                500
            );
        }
    }

    public function updateCart (Request $request , $id)
    {
        $cart = Cart::findOrFail($id);
        $cart->update($request->all());
        return ResponseFormmater::success(
            $cart,
            'Success update cart'
        );
    }

    public function destroyCart (Request $request, $id)
    {
        $cart = Cart::findOrFail($id);
        $cart->delete();
        return ResponseFormmater::success(
            $cart,
            'Success delete cart'
        );
    }

    public function cart (Request $request)
    {
        $id = $request->input('id');
        $user_id = $request->input('user_id');
        $limit = $request->input('limit', 10);
        $status_cart = $request->input('status_cart');

        if($id)
        {
            $cart = Cart::with(['users'])->find($id);

            if($cart)
            {
                return ResponseFormmater::success(
                    $cart,
                    'Success get cart'
                );
            }

            else {
                return ResponseFormmater::error(
                    null,
                    'Cart not found',
                    404
                );
            }

        }

        $cart = Cart::with(['users']);


        if($user_id)
        {
            $cart->where('user_id', $user_id);
        }

        if($status_cart)
        {
            $cart->where('status_cart', $status_cart);
        }

        return ResponseFormmater::success(
            $cart->paginate($limit),
            'Success List get cart'
        );
    }
}
