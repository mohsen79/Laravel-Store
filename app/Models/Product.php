<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Action\Entities\Action;
use Modules\Comment\Entities\Comment;
use Modules\Gallery\Entities\ProductGallery;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'description', 'price', 'inventory', 'user_id', 'image', 'view_count', 'brand'];
    public function users()
    {
        return $this->belongsTo(User::class);
    }
    public function attributes()
    {
        return $this->belongsToMany(Attribute::class)->using(AttributeProductValue::class)->withPivot('value_id');
    }
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }
    public function gallery()
    {
        return $this->hasMany(ProductGallery::class);
    }
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
    public function actions()
    {
        return $this->morphMany(Action::class, 'actionable');
    }
}
