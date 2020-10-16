<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $products = Product::all();
        return response()->json($products);
    }
    public function create(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string',
            'desc' => 'required|string',
            'price' => 'required|integer',
            'category' => 'required|in:food,drink'
        ]);
        $data = $request->all();
        $product = Product::create($data);
        return response()->json($product);
    }
    public function update(Request $request, $id)
    {
        $product = Product::find($id);
        $this->validate($request, [
            'name' => 'string',
            'desc' => 'string',
            'price' => 'integer',
            'category' => 'in:food,drink'
        ]);
        $data = $request->all();
        $product->fill($data);
        $product->save();
        return response()->json($product);
    }
    public function show($id)
    {
        $product = Product::find($id);
        return response()->json($product);
    }
    public function delete($id)
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json([
                'message' => 'Product not found!'
            ], 404);
        }
        $product->delete();
        return response()->json(['message' => 'Product deleted!']);
    }
}
