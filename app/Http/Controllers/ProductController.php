<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filterKeyword = $request->get('keyword');
        $product['product'] = Product::with(['category', 'variants'])->paginate(10);

        if($filterKeyword)
        {
            $product['product'] = Product::with(['category', 'variants'])
            ->where("name_product", "LIKE", "%$filterKeyword%")
            ->paginate(10);
        }

        return view('product.index', $product);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category = Category::all();
        return view('product.create', compact('category'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'name_product' => 'required|string|max:255',
            'description' => 'required',
            'price_product' => 'required|numeric',
            'price_strike' => 'required|numeric',
            'category_id' => 'sometimes|exists:categories,id',
        ]);

        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate)->withInput();
        }

        $input = $request->all();
        $product = Product::create($input);



        if ($request->has('variants')) {
            foreach ($request->variants as $index => $variantData) {
                $variantName = $variantData['name'];
                $imageFile = $request->file('variants')[$index]['image'] ?? null;

                $fileName = null;
                if ($imageFile && $imageFile->isValid()) {
                    $fileName = "product/" . date('YmdHis') . "_" . uniqid() . "." . $imageFile->getClientOriginalExtension();
                    $uploadPath = env('UPLOAD_PATH') . "/product";
                    $imageFile->move($uploadPath, $fileName);
                }

                $product->variants()->create([
                    'variant_name' => $variantName,
                    'image_product' => $fileName,
                ]);
            }
        }

        if ($request->has('sizes')) {
            foreach ($request->sizes as $size) {
                if (!empty($size['name'])) {
                    $product->sizes()->create([
                        'name_size' => $size['name']
                    ]);
                }
            }
        }

        return redirect()->route('product.index')->with('status', 'Data Product Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return redirect()->back()->with('status', 'Product Berhasil didelete');
    }
}
