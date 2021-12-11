<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\User;
use App\Models\Attribute;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Modules\Action\Entities\Action;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::all();
        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.products.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $this->validate($request, [
            'title' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'inventory' => 'required|numeric',
            'category' => 'required',
            'attributes' => 'array',
            'image' => 'required',
            'brand' => 'required|string'
        ]);
        $cat = Category::find($data["category"]);
        // dd($cat->parent_id);
        // $file = $request->file('image');
        // $destination = '/img/' . now()->year . '/' . now()->month . '/' . now()->day . '/';
        // $file->move(public_path($destination), $file->getClientOriginalName());
        // $data["image"] = $destination . $file->getClientOriginalName();
        $product = auth()->user()->products()->create($data);
        $product->actions()->create([
            'user_id' => auth()->user()->id,
            'object_name' => $product->title,
            'action' => 'create product',
            'date' => now(),
        ]);
        $product->categories()->sync([$data["category"]]);
        if (isset($data["attributes"])) {
            $attributes = collect($data["attributes"]);
            $attributes->each(function ($item) use ($product) {
                if (is_null($item["name"]) || is_null($item["value"])) return;
                $attr = Attribute::firstOrCreate([
                    'name' => $item["name"]
                ]);
                $attr_value = $attr->values()->firstOrCreate([
                    'value' => $item["value"]
                ]);
                $product->attributes()->attach($attr->id, ['value_id' => $attr_value->id]);
            });
        }
        return redirect('admin/products');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $data = $this->validate($request, [
            'title' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'inventory' => 'required|numeric',
            'category' => 'required',
            'attributes' => 'array',
            'image' => 'string',
            'brand' => 'required|string'
        ]);
        // if ($request->file('image')) {
        //     $this->validate($request, [
        //         'image' => 'required|mimes:png,jpg|max:2048'
        //     ]);
        //     if (File::exists(public_path($product->image))) {
        //         File::delete(public_path($product->image));
        //     }
        //     $file = $request->file('image');
        //     $destination = '/img/' . now()->year . '/' . now()->month . '/' . now()->day . '/';
        //     $file->move(public_path($destination), $file->getClientOriginalName());
        //     $data["image"] = $destination . $file->getClientOriginalName();
        // }
        $product->update($data);
        $product->categories()->sync($data["category"]);
        $product->attributes()->detach();
        if (isset($data["attributes"])) {
            $attributes = collect($data["attributes"]);
            $attributes->each(function ($item) use ($product) {
                if (is_null($item["name"]) || is_null($item["value"])) return;
                $attr = Attribute::firstOrCreate([
                    'name' => $item["name"]
                ]);
                $attr_value = $attr->values()->firstOrCreate([
                    'value' => $item["value"]
                ]);
                $product->attributes()->attach($attr->id, ['value_id' => $attr_value->id]);
            });
        }
        $product->actions()->create([
            'user_id' => auth()->user()->id,
            'object_name' => $product->title,
            'action' => 'update product',
            'date' => now(),
        ]);
        return redirect('admin/products');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->actions()->create([
            'user_id' => auth()->user()->id,
            'object_name' => $product->title,
            'action' => 'delete product',
            'date' => now(),
        ]);
        $product->delete();
        return back();
    }
}
