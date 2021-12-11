<?php

namespace Modules\Action\Entities;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Action extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['user_id', 'action', 'date', 'actionable_id', 'actionable_type', 'object_name','actionable'];

    protected static function newFactory()
    {
        return \Modules\Action\Database\factories\ActionFactory::new();
    }

    public function actionable()
    {
        return $this->morphTo();
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    // public function users()
    // {
    //     return $this->morphTo(User::class);
    // }
    // public function products()
    // {
    //     return $this->morphTo(Product::class);
    // }
}
