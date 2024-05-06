<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormmater;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function product (Request $request)
    {
        $id = $request->input('id');
        $limit = $request->input('limit', 10);
        $name_product = $request->input('name_product');
        $category_id = $request->input('category_id');
        $cheap = $request->input('cheap');
        $expensive = $request->input('expensive');


        if($id)
        {
            $product = Product::with(['category', 'variants' , 'sizes', 'rates'])->find($id);

            if($product)
            {
                return ResponseFormmater::success(
                    $product,
                    'Product berhasil diambil'
                );
            }

            else {
                return ResponseFormmater::error(
                    null,
                    'Product tidak ditemukan',
                    404,
                );
            }
        }

        $product = Product::with(['category', 'variants' , 'sizes', 'rates']);

        if($name_product)
        {
            $product->where('name_product', 'like', '%' . $name_product . '%');
        }

        if($category_id)
        {
            $product->where('category_id', $category_id);
        }

        if($cheap) {
            $product->orderBy('price_product', 'asc');
        }

        if($expensive) {
            $product->orderBy('price_product', 'desc');
        }


        return ResponseFormmater::success(
            $product->paginate($limit),
            'Product berhasil diambil'
        );
    }
}
