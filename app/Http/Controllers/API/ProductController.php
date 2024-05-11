<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormmater;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

    public function productFavorite(Request $request)
    {
        $id = $request->input('id');
        $limit = $request->input('limit', 10);
        $name_product = $request->input('name_product');
        $category_id = $request->input('category_id');

        if ($id) {
            $product = Product::with(['category', 'variants' , 'sizes', 'rates'])->find($id);

            if ($product) {
                return ResponseFormmater::success(
                    $product,
                    'Product berhasil diambil'
                );
            } else {
                return ResponseFormmater::error(
                    null,
                    'Product tidak ditemukan',
                    404
                );
            }
        }

        $query = Product::with(['category', 'variants' , 'sizes', 'rates']);

        if ($name_product) {
            $query->where('name_product', 'like', '%' . $name_product . '%');
        }

        if ($category_id) {
            $query->where('category_id', $category_id);
        }

        // Subquery untuk menghitung jumlah rating
        $subquery = DB::table('products')
                    ->leftJoin('rates', 'products.id', '=', 'rates.product_id')
                    ->select('products.id', DB::raw('COUNT(rates.id) as rating_count'))
                    ->groupBy('products.id');

        // Join dengan hasil subquery
        $query->joinSub($subquery, 'sub', function ($join) {
            $join->on('products.id', '=', 'sub.id');
        })
        ->select('products.*', 'sub.rating_count')
        ->orderByDesc('sub.rating_count')
        ->limit($limit);

        $products = $query->get();

        return ResponseFormmater::success(
            $products,
            'Product berhasil diambil'
        );
    }
}
