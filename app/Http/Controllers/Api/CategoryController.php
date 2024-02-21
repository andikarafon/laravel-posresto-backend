<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{

    //index api
    public function index()
    {
        // $products = Product::paginate(10);
        $categories = Category::all(); //get all products
        return response()->json([
            'status'        => 'success',
            'data'          => $categories
        ], 200);
    }
}
