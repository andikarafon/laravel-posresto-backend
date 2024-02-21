<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::paginate(10);
        return view('pages.categories.index', compact('categories'));
    }

    //create
    public function create()
    {
        return view('pages.categories.create');
    }

    //store
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3',
            'description' => 'required',
            'image' => 'required|image|mimes:png,jpg,jpeg,gif,svg|max:2048',
        ]);

        $filename = time() . '.' . $request->image->extension();
        $request->image->storeAs('public/products', $filename);
        $data = $request->all();

        $category = new Category;
        $category->name = $request->name;
        $category->description = $request->description;
        $category->image = $filename;
        $category->save();

        return redirect()->route('categories.index')->with('success', 'Category successfully created');

    }

    //edit
    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('pages.categories.edit', compact('category'));
    }

    //update
    public function update(Request $request, $id)
    {
        $data = $request->all();
        $category = \App\Models\Category::findOrFail($id);
        $category->update($data);
        return redirect()->route('categories.index')->with('success', 'Category successfully updated');
    }

    public function destroy($id)
    {
        $category = \App\Models\Category::findOrFail($id);
        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Category successfully deleted');
    }

}
