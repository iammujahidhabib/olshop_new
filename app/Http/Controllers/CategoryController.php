<?php

namespace App\Http\Controllers;
use App\Models\Category;

use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $category = Category::all();
        return view('admin.category',['category'=>$category]);
    }
    public function save(Request $request)
    {
        Category::create($request->all());
        // Category::create(['category'=> $request->category]);
        return response()->json(['status'=>'success']);
    }
    public function all()
    {
        $categoryAll = Category::all();

        return response()->json($categoryAll);
    }
    public function show($id)
    {
        $category = Category::find($id);

        return response()->json($category);
    }
    public function update(Request $request)
    {
        Category::where(['id'=>$request->id])->update(['category'=>$request->category]);
        return response()->json(['status'=>'success']);
    }
    public function delete($id)
    {
        Category::destroy($id);

        return response()->json(['response' => 'success']);
    }
}
