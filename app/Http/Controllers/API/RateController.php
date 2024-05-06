<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormmater;
use App\Http\Controllers\Controller;
use App\Models\Rate;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RateController extends Controller
{

    public function storeRate (Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'product_id' => 'sometimes|exists:products,id',
            'variant_rate' => 'required|string|max:255',
            'size_rate' => 'required|string|max:255',
            'category_rate' => 'required|string|max:255',
            'image_rate' => 'required|string|max:255',
            'rating' => '',
            'reviews' => '',
        ]);


        if($validator->fails()) {
            return ResponseFormmater::error(
                null,
                $validator->errors(),
                500
            );
        }

        $rate = Rate::create([
            'user_id' => $request->user_id,
            'product_id' => $request->product_id,
            'variant_rate' => $request->rating,
            'size_rate' => $request->reviews,
            'category_rate' => $request->variant_product,
            'image_rate' => $request->name_category,
            'rating' => $request->image_product,
            'reviews' => $request->reviews
        ]);


        try {
            $rate->save();
            return ResponseFormmater::success(
                $rate,
                'Data Rate  Berhasil di tambahkan'
            );
        }

        catch(Exception $error) {
            return ResponseFormmater::error(
                $error->getMessage(),
                'Data Rate  tidak ada',
                404
            );
        }
    }
}
