<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
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
}
