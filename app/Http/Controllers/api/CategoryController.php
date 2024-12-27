<?php

namespace App\Http\Controllers\api;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
   public function index(Request $request) {
       $categories = Category::where('seller_id', $request->user()->id)->get();

       return response()->json([
           'status' => 'success',
           'message'=> 'Kategori Tersedia',
           'data' => $categories
       ],201);

   }

   /**
    * Store a newly created resource in storage.
    */
   public function store(Request $request)
   {
       $request->validate([
           'name' => 'required|string',
           'description' => 'string'
       ]);

       $category = Category::create([
           'seller_id' => $request->user()->id,
           'name' => $request->name,
           'description' => $request->description
       ]);

       return response()->json([
           'status' => 'success',
           'message'=> 'Kategori Berhasil dibuat!',
           'data' => $category
       ],201);
   }
}

