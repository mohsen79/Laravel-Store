<?php

namespace Modules\Gallery\Http\Controllers;

use App\Models\Product;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Gallery\Entities\ProductGallery;

class GalleryController extends Controller
{
    public function index(Product $product)
    {
        $progal = ProductGallery::all();
        return view('gallery::index', compact('progal', 'product'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Product $product)
    {
        return view('gallery::create', compact('product'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Product $product)
    {
        $data = $request->validate([
            'alt' => 'required',
            'image' => 'required'
        ]);
        $product->gallery()->create($data);
        return redirect(route('admin.product.gallery.index', $product->id));
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
    public function edit(Product $product, ProductGallery  $gallery)
    {
        return view('gallery::edit', ['product' => $product, 'gallery' => $gallery]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product, ProductGallery $gallery)
    {
        $data = $request->validate([
            'alt' => 'required',
            'image' => 'required'
        ]);
        $gallery->update($data);
        return redirect(route('admin.product.gallery.index', $product->id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product, ProductGallery $gallery)
    {
        $gallery->delete();
        return back();
    }
}
