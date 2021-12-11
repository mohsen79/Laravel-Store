<?php

namespace Modules\Discount\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Cart\Helpers\Cart;
use Modules\Discount\Entities\Discount;

class CartDiscountController extends Controller
{
    public function checkDiscount(Request $request)
    {
        $data = $request->validate([
            'code' => 'required|exists:discounts,code'
        ]);
        if (!auth()->check()) {
            return back()->withErrors([
                'discount' => 'you have log in to use discount'
            ]);
        }
        $discount = Discount::whereCode($data["code"])->first();
        if ($discount->expire < now()) {
            return back()->withErrors([
                'discount' => 'discount has been terminated'
            ]);
        }
        if ($discount->users()->count()) {
            if (!in_array(auth()->user()->id, $discount->users()->pluck('id')->toArray())) {
                return back()->withErrors([
                    'discount' => 'you can not use this discount'
                ]);
            }
        }
        Cart::addDiscount($discount->code);
        return back();
    }
    public function delete()
    {
        Cart::addDiscount(null);
        return back();
    }
}
