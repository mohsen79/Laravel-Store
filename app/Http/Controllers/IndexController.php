<?php

namespace App\Http\Controllers;

use App\Models\Attribute;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Cart\Helpers\Cart;
use Illuminate\Support\Facades\Cookie;
use Nwidart\Modules\Facades\Module;

class IndexController extends Controller
{
    public function show()
    {
        $categories = Category::all()->where('parent_id', 0);
        if (isset($_GET["cat"])) {
            $id = $_GET["cat"];
            $cat = Category::find($id);
            // if ($cat->parent_id == 0) {
            //     $pro = $cat->child;
            //     // $pro = $cat->child->pluck('products');
            //     // foreach ($pro as $p) {
            //     //     $new = $p->reverse();
            //     //     $new = $new->all();
            //     //     foreach ($new as $key) {
            //     //         $pro = $key;
            //     //     }
            //     // }
            //     return view('main', ['categories' => $categories, 'products' => $pro]);
            // } else {
            $pro = $cat->products;
            // request()->fullUrlWithQuery(['/ ' => null]);
            return view('main', ['categories' => $categories, 'products' => $pro]);
            // }
        }
        $products = Product::query();
        if ($keyword = request('search')) {
            $products->where('id', 'LIKE', "%{$keyword}%")->orWhere('title', 'LIKE', "%{$keyword}%")
                ->orWhere('description', 'LIKE', "%{$keyword}%");
        }
        $products = $products->latest()->paginate(4);
        return view('main', compact('products', 'categories'));
    }
    public function filter(Request $request)
    {
        if ($request->inventory == 'on') {
            $products = Product::query();
            $products = $products->where('inventory', '>', 1);
        } else {
            $products = Product::query();
        }
        $categories = Category::all()->where('parent_id', 0);
        if ($keyword = request('search')) {
            $products->where('id', 'LIKE', "%{$keyword}%")->orWhere('title', 'LIKE', "%{$keyword}%")
                ->orWhere('description', 'LIKE', "%{$keyword}%");
            $products = $products->latest()->paginate();
            return view('main', compact('products', 'categories'));
        }
        foreach (collect($request->all()) as $key => $req) {
            switch ($key) {
                case 'brand':
                    if (is_null($request->brand)) break;
                    $products->where('brand', $request->all()["brand"]);
                    $products = $products->latest()->paginate();
                    $request->session('filter')->put(['brand' => $request->brand]);
                    return view('main', compact('products', 'categories'));
                    break;
                case 'color':
                    if (is_null($request->color)) break;
                    foreach (Product::all() as $product) {
                        foreach ($product->attributes as $attr) {
                            if ($attr->pivot->value->value == $request->all()["color"]) {
                                $products = $product->where('id', $attr->pivot->product->id);
                                $products = $products->latest()->paginate();
                                $request->session('filter')->put(['color' => $request->color]);
                                return view('main', compact('products', 'categories'));
                            }
                        }
                    }
                    break;
                case 'range':
                    if (is_null($request->range) or $request->range == 0) break;
                    $products = $products->where('price', '<', $request->range);
                    $products = $products->latest()->paginate();
                    $request->session('filter')->put(['range' => $request->range]);
                    return view('main', compact('products', 'categories'));
                    break;
            }
        }
        if ($request->session('filter')) {
            $new_req = $request->session('filter');
            $this->callback($new_req);
        }
        $products = $products->latest()->paginate(4);
        return view('main', compact('products', 'categories'));
    }
    public function callback($request)
    {
        // dd($request);
        $products = Product::query();
        $categories = Category::all()->where('parent_id', 0);
        if ($request->get('color') && $request->get('range')) {
            // dd($request->get('color'), $request->get('range'));
            // dd('dourd');
            // $products = $products->where('price', '<', $request->get('range'));
            foreach (Product::all() as $product) {
                foreach ($product->attributes as $attr) {
                    if ($attr->pivot->value->value == $request->all()["color"]) {
                        $products = $product->where('id', $attr->pivot->product->id)->where('price', '<', $request->get('range'));
                        $products = $products->latest()->paginate(5);
                        return view('main', compact('products', 'categories'));
                    }
                }
            }
            // $products = $products->latest()->paginate();
            return view('main', compact('products', 'categories'));
        }
    }
}
