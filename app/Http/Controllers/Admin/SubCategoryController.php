<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{
    public function create(Category $category)
    {
        return view('admin/categories/subcategory/create', compact('category'));
    }
    public function store(Request $request, Category $category)
    {
        $data = $this->validate($request, [
            'name' => 'required',
        ]);
        Category::create([
            'name' => $data["name"],
            'parent_id' => $category->id
        ]);
        return redirect('admin/categories');
    }
    public function edit(Category $category)
    {
        return view('admin/categories/subcategory/edit', compact('category'));
    }
    public function update(Request $request, Category $category)
    {
        $data = $this->validate($request, [
            'name' => 'required',
        ]);
        $category->update([
            'name' => $data["name"],
            'parent_id' => $request->parent_id
        ]);
        return redirect('admin/categories');
    }
    public function destroy(Category $category)
    {
        $category->delete();
        return back();
    }
}
