<?php

namespace Modules\Cart\Http\Controllers;

use App\lib\zarinpal;
use App\Models\Product;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Carbon\Carbon;
use Exception;
use Faker\Provider\ar_SA\Payment;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Route;
use Modules\Cart\Entities\Cart as EntitiesCart;
use Modules\Cart\Helpers\Cart;



class CartController extends Controller
{
    public function index()
    {
        return view('cart::index');
    }
    public function AddToCart(Product $product)
    {
        if (Cart::has($product)) {
            if (Cart::count($product) < $product->inventory) {
                Cart::update($product, 1);
            }
        } else {
            Cart::put([
                'quantity' => 1,
                'price' => $product->price
            ], $product);
        }
        // return redirect('cart');
        return redirect('/');
    }
    public function QuantityChange(Request $request)
    {
        $data = $request->validate([
            'id' => 'required',
            'quantity' => 'required'
        ]);
        if (Cart::has($data["id"])) {
            Cart::update($data["id"], [
                'quantity' => $data["quantity"]
            ]);
            return response(['status' => 'success']);
        }
        return response(['status' => 'error'], 404);
    }
    public function remove($id)
    {
        Cart::remove($id);
        return back();
    }
    public function StoreCart(Request $request)
    {
        $order = new zarinpal();
        $res = $order->pay($request->total_price, "mohsen@gmail.com", "0909090909");
        return redirect('https://www.zarinpal.com/pg/StartPay/' . $res);
    }
    public function callback(Request $request)
    {

        $MerchantID = '5e682ada-3b69-11e8-aaf3-005056a205be';
        $Authority = $request->get('Authority');

        //ما در اینجا مبلغ مورد نظر را بصورت دستی نوشتیم اما در پروژه های واقعی باید از دیتابیس بخوانیم
        $Amount = 100;
        if ($request->get('Status') == 'OK') {
            $client = new nusoap_client('https://www.zarinpal.com/pg/services/WebGate/wsdl', 'wsdl');
            $client->soap_defencoding = 'UTF-8';

            //در خط زیر یک درخواست به زرین پال ارسال می کنیم تا از صحت پرداخت کاربر مطمئن شویم
            $result = $client->call('PaymentVerification', [
                [
                    //این مقادیر را به سایت زرین پال برای دریافت تاییدیه نهایی ارسال می کنیم
                    'MerchantID'     => $MerchantID,
                    'Authority'      => $Authority,
                    'Amount'         => $Amount,
                ],
            ]);

            if ($result['Status'] == 100) {
                $carts = Cart::all();
                foreach ($carts as $cart) {
                    $product = $cart["Product"];
                    EntitiesCart::create([
                        'name' => $product["title"],
                        'price' => $product["price"],
                        'quantity' => $cart["quantity"],
                        'user_id' => auth()->user()->id,
                        'total_price' => $cart["quantity"] * $product["price"],
                        'product_id' => $product["id"],
                        'status' => 'order',
                        'date' => Carbon::now()
                    ]);
                }
                Cart::flush();
                echo 'you paid successfully';
                return back();
            } else {
                echo 'invalid information';
                echo "<script>setTimeout(function (){
                    window.location.href = '/';
                },3000);</script>";
            }
        } else {
            echo 'you canceled the operation';
            echo "<script>setTimeout(function (){
                window.location.href = '/';
            },3000);</script>";
        }
    }
    // public function callback()
    // {
    //     dd('you are back');
    // }
}
