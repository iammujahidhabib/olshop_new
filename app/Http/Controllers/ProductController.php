<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
// use Storage;
use Illuminate\Support\Facades\Storage;
use App\Models\Product;
use App\Models\Category;
use App\Models\Picture;

class ProductController extends Controller
{
    public function index()
    {
        $categories=Category::all();
        return view('admin.product', compact(['categories']));
    }
    public function save(Request $request)
    {
        // $getID = Product::insertGetId($request->all());
        $this->validate($request, [
            'picture' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2000'
        ]);

        // $uploadedFile = $request->file('file');

        // $path = $uploadedFile->store('public/files');
        // $fileName = $request->file('picture')->getClientOriginalName();

        $path = Storage::putFile(
            'public/images',
            $request->file('picture'),
        );
        $newpath=substr($path,7);

        $getID = Product::insertGetId(['product'=>$request->product,'price'=>$request->price,'stock'=>$request->stock,'desc'=>$request->desc,'id_category'=>$request->id_category]);
        Picture::create(['id_product'=>$getID,'picture'=>$newpath]);

        return response()->json(['status'=>'success','id'=>$getID]);
    }
    public function all()
    {
        $productAll = Product::all();

        return response()->json($productAll);
    }
    public function show($id)
    {
        $product = Product::find($id);
        $pictureProduct = Picture::where('id_product',$id)->cursor();

        return response()->json(compact('product','pictureProduct'));
    }
    public function update(Request $request)
    {
        if(!empty($request->file('picture'))){
            $this->validate($request, [
                'picture' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2000'
            ]);
            $path = Storage::putFile(
                'public/images',
                $request->file('picture'),
            );

            $newpath=substr($path,7);
            Picture::create(['id_product'=>$request->id,'picture'=>$newpath]);
        }
        Product::where(['id'=>$request->id])->update(['product'=>$request->product,'price'=>$request->price,'stock'=>$request->stock,'desc'=>$request->desc]);
        return response()->json(['status'=>'success']);
    }
    public function delete($id)
    {
        Product::destroy($id);

        return response()->json(['response' => 'success']);
    }
    public function detail($id)
    {
        // $product = Product::with('category')->where('id',$id)->get();
        // $pictureProduct = Picture::where('id_product',$id)->cursor();
        // echo "<pre>";
        // print_r($product);
        // echo "</pre>";
        return view('admin.productdetail');//, compact('product','pictureProduct'));
        // return response()->json(compact('product','pictureProduct'));
    }
}
