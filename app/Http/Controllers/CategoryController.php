<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filterKeyword = $request->get('keyword');
        $query = Category::query();

        if($filterKeyword) {
            $query->where('name_category', 'like', '%' . $filterKeyword . '%');
        }

        $category['category'] = $query->paginate(10);
        return view('category.index', $category);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name_category' => 'required|string|max:255',
            'image_category' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $cek = Category::where('name_category', $request->name_category);

        if($cek->first()) {
            return redirect()->back()->with('failed', 'Kategori Jasa Ini Sudah pernah anda buat');
        }

        $input = $request->all();

        if($request->file('image_category')->isValid()) {
            $photoCategory = $request->file('image_category');
            $extensions = $photoCategory->getClientOriginalExtension();
            $categoryUpload = "category/".date('YmdHis').".".$extensions;
            $categoryPath = \env('UPLOAD_PATH'). "/category";
            $request->file('image_category')->move($categoryPath, $categoryUpload);
            $input['image_category'] = $categoryUpload;
        }

        $input['name_category'] = strtoupper($request->name_category);
        Category::create($input);
        return redirect()->route('category.index')->with('status', 'Category Berhasil dibuat');
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
        $category['category'] = Category::findOrFail($id);
        return view('category.edit', $category);
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
        $category = Category::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name_category' => 'sometimes|string|max:255',
            'image_category' => 'sometimes|mimes:png,jpg|max:2048'

        ]);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $input = $request->all();

        if($request->hasFile('image_category')) {
            if($request->file('image_category')->isValid()) {
                Storage::disk('upload')->delete($category->image_category);
                $photoCategory = $request->file('image_category');
                $extensions = $photoCategory->getClientOriginalExtension();
                $categoryUpload = "category/".date('YmdHis').".".$extensions;
                $categoryPath = \env('UPLOAD_PATH'). "/category";
                $request->file('image_category')->move($categoryPath, $categoryUpload);
                $input['image_category'] = $categoryUpload;
            }
        }

        $category->update($input);
        return redirect()->route('category.index')->with('status', 'Category Berhasil di update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $input = Storage::disk('upload')->delete($category->image_category);
        $category->delete($input);
        return redirect()->back()->with('status', 'Kategori Berhasil didelete');
    }
}
