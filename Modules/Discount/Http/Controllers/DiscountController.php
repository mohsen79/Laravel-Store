<?php

namespace Modules\Discount\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Validation\Rule;
use Modules\Discount\Entities\Discount;

class DiscountController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $discounts = Discount::all();

        return view('discount::index', compact('discounts'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $users = User::all();
        $products = Product::all();
        $categories = Category::all();
        return view('discount::create', compact('users', 'products', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'code' => 'required',
            'percent' => 'required|numeric',
            'expire' => 'required|date'
        ]);
        $discount = Discount::create($data);
        $discount->products()->attach($request->products);
        $discount->categories()->attach($request->categories);
        $discount->users()->attach($request->users);

        return redirect(route('discounts.index'));
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('discount::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit(Discount $discount)
    {
        $users = User::all();
        $products = Product::all();
        $categories = Category::all();
        return view('discount::edit', compact(['users', 'products', 'categories', 'discount']));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, Discount $discount)
    {
        $data = $request->validate([
            'code' => ['required', Rule::unique('discounts', 'code')->ignore($discount->id)],
            'percent' => 'required|numeric',
            'expire' => 'required|date',
            'users' => 'array',
            'products' => 'array',
            'categories' => 'array'
        ]);
        $discount->update($data);
        isset($data["users"]) ? $discount->users()->sync($data["users"]) : $discount->users()->detach();
        isset($data["products"]) ? $discount->products()->sync($data["products"]) : $discount->products()->detach();
        isset($data["categories"]) ? $discount->categories()->sync($data["categories"]) : $discount->categories()->detach();

        return redirect(route('discounts.index'));
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(Discount $discount)
    {
        $discount->delete();
        return back();
    }
}
