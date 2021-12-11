<?php

namespace Modules\Cart\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'user_id', 'product_id', 'total_price', 'price', 'quantity', 'status', 'date'];
    public $timestamps = false;

    protected static function newFactory()
    {
        return \Modules\Cart\Database\factories\CartFactory::new();
    }
    public  function user()
    {
        return $this->belongsTo(User::class);
    }
}
