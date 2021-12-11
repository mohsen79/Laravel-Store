<?php

namespace Modules\Discount\Entities;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Discount extends Model
{
    use HasFactory;

    protected $fillable = ['code', 'percent', 'expire', 'user_id', 'category_id', 'product_id'];

    protected static function newFactory()
    {
        return \Modules\Discount\Database\factories\DiscountFactory::new();
    }
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }
}
