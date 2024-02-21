<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    //index api
    public function index()
    {
        // $products = Product::paginate(10);
        $products = Product::all(); //get all products
        return response()->json([
            'status'        => 'success',
            'data'          => $products
        ], 200);
    }
}
