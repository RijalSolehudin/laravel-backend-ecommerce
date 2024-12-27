<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Products::where('seller_id', $request->user()->id)->with('category','seller')->get();
        return response()->json([
            'status' => 'success',
            'message' => 'Data Produk Tersedia',
            'data' => $products
        ], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string',
            'description' => 'string',
            'price' => 'required',
            'stock' => 'required|integer',
            'image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $image = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image')->store('assets/products', 'public');
        }

        $product = Products::create([
            'seller_id' => $request->user()->id,
            'category_id' => $request->category_id,
            'name' => $request->name,
            'description' =>  $request->description,
            'price' =>  $request->price,
            'stock' => $request->stock,
            'image' =>  $image,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Produk Berhasil DiUpload',
            'data' => $product,
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string',
            'description' => 'required|string',
            'price' => 'required',
            'stock' => 'required|integer',
            'image' => 'image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $product = Products::find($id);


        if (!$product) {
            return response()->json([
            'status' => 'failed',
            'message' => 'Produk tidak ditemukan',
            ],404);
        }

        $product->update([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'description' =>  $request->description,
            'price' =>  $request->price,
            'stock' => $request->stock,
        ]);
        
        if($request->hasFile('image')){
            $image = $request->file('image')->store('assets/products', 'public');
            $product->image = $image;
            $product->save();
        };
        

        return response()->json([
            'status' => 'success',
            'message' => 'Produk Berhasil Di Ubah',
            'data' => $product,
        ], 200);
    }

    public function destroy($id) {
        $product = Products::find($id);

        if (!$product) {
            return response()->json([
            'status' => 'failed',
            'message' => 'Produk tidak ditemukan',
            ],404);
        }

        $product->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Produk berhasil dihapus',
            ],200);

    }

}
