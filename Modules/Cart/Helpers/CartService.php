<?php

namespace Modules\Cart\Helpers;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;
use Modules\Discount\Entities\Discount;

class CartService
{
    protected $cart;
    public function __construct()
    {
        $cart = collect(json_decode(request()->cookie('cart'), true));
        $this->cart = $cart->count() ? $cart : collect([
            'items' => [],
            'discount' => null
        ]);
    }
    public function exist()
    {
        if (!auth()->check()) {
            $this->cart["items"] = "";
            Cookie::queue(Cookie::forget('cart'));
        }
        return $this->cart["items"];
    }
    public function put(array $value, $obj = null)
    {
        if (!is_null($obj) && $obj instanceof Model) {
            $value = array_merge($value, [
                'id' => Str::random(10),
                'subject_id' => $obj->id,
                'subject_type' => get_class($obj),
                'discount_percent' => 0
            ]);
        } elseif (!isset($value["id"])) {
            $value = array_merge($value, [
                'id' => Str::random(10)
            ]);
        }
        $this->cart["items"] = collect($this->cart["items"])->put($value["id"], $value);
        Cookie::queue('cart', $this->cart->toJson(), 60 * 24 * 2);
        return $this;
    }
    public function has($key)
    {
        if ($key instanceof Model) {
            return !is_null(
                collect($this->cart["items"])->where('subject_id', $key->id)->where('subject_type', get_class($key))->first()
            );
        }
        return !is_null(collect($this->cart["items"])->firstwhere('id', $key));
    }
    public function get($key, $withrelationship = true)
    {
        $item = $key instanceof Model ?
            collect($this->cart["items"])->where('subject_id', $key->id)->where('subject_type', get_class($key))->first()
            : collect($this->cart["items"])->firstwhere('id', $key);
        return $withrelationship ? $this->relationship($item) : $item;
    }
    public function relationship($item)
    {
        if (isset($item["subject_id"]) and isset($item["subject_type"])) {
            $class = $item["subject_type"];
            $subject = (new $class())->find($item["subject_id"]);
            $item[class_basename($class)] = $subject;
            return $item;
        }
        return $item;
    }
    public function all()
    {
        $cart = $this->cart;
        $cart = collect($this->cart["items"])->map(function ($item) use ($cart) {
            $item = $this->relationship($item);
            $item = $this->checkDiscount($item, $cart["discount"]);
            return $item;
        });
        return $cart;
    }
    public function update($key, $option)
    {
        $item = collect($this->get($key, false));
        if (is_numeric($option)) {
            $item = $item->merge([
                'quantity' => $item["quantity"] + $option
            ]);
        }
        if (is_array($option)) {
            $item = $item->merge($option);
        }
        $this->put($item->toArray());
        return $this;
    }
    public function count($key)
    {
        if (!$this->get($key)) return 0;
        return $this->get($key)["quantity"];
    }
    public function remove($key)
    {
        if ($this->has($key)) {
            $this->cart["items"] = collect($this->cart["items"])->filter(function ($item) use ($key) {
                if ($key instanceof Model) {
                    return ($item["subject_id"] != $key->id) && ($item["subject_type"] != get_class($key));
                }
                return $key != $item["id"];
            });
            Cookie::queue('cart', $this->cart->toJson(), 60 * 24 * 2);
            return true;
        }
        return false;
    }
    public function flush()
    {
        $this->cart = collect([]);
        Cookie::queue('cart', $this->cart->toJson(), 60 * 24 * 2);
        return $this;
    }
    public function addDiscount($discount)
    {
        $this->cart["discount"] = $discount;
        Cookie::queue('cart', $this->cart->toJson(), 60 * 24 * 2);
    }
    public function checkDiscount($item, $discount)
    {
        $discount = Discount::where('code', $discount)->first();
        if ($discount and $discount->expire > now()) {
            if (
                (!$discount->products->count() && !$discount->categories->count()) ||
                in_array($item["Product"]->id, $discount->products->pluck('id')->toArray()) ||
                array_intersect(
                    $item["Product"]->categories->pluck('id')->toArray(),
                    $discount->categories->pluck('id')->toArray()
                )
            ) {
                if ($item["quantity"] > 3) {
                    $item["discount_percent"] = ($discount->percent + 10) / 100;
                } else {
                    $item["discount_percent"] = $discount->percent / 100;
                }
            }
        }
        return $item;
    }
    public function getdiscount()
    {
        return Discount::whereCode($this->cart["discount"])->first();
    }
}
