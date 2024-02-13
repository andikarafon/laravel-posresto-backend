<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index()
    {
        // $products = DB::table('products')->paginate(10);
        $products = Product::paginate(5);
        return view('pages.products.index', compact('products'));
    }

    public function create()
    {
        // ambil categories
        $categories = DB::table('categories')->get();
        return view('pages.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3|unique:products',
            'description' => 'required',
            'price' => 'required|integer',
            'category_id' => 'required',
            'stock' => 'required|integer',
            'status' => 'required|numeric',
            'is_favorite' => 'required|boolean',
            'image' => 'required|image|mimes:png,jpg,jpeg'
        ]);

        $filename = time() . '.' . $request->image->extension();
        $request->image->storeAs('public/products', $filename);
        $data = $request->all();

        $product = new \App\Models\Product;
        $product->name = $request->name;
        $product->description = $request->description;
        $product->category_id = $request->category_id;
        $product->stock = (int) $request->stock;
        $product->price = (int) $request->price;
        $product->status = $request->status;
        $product->is_favorite = $request->is_favorite;
        $product->image = $filename;
        $product->save();

        return redirect()->route('products.index')->with('success', 'Product successfully created');
    }

    //edit
    public function edit($id)
    {
        $categories = DB::table('categories')->get();
        $product = Product::findOrFail($id);
        return view('pages.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        $product = \App\Models\Product::findOrFail($id);
        $product->update($data);
        return redirect()->route('products.index')->with('success', 'Product successfully updated');
    }

    public function destroy($id)
    {
        $product = \App\Models\Product::findOrFail($id);
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Product successfully deleted');
    }

}
