<?php

namespace Modules\Comment\Entities;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = ['comment', 'parent_id', 'commentable_id', 'commentable_type', 'approved'];
    public function products()
    {
        return $this->morphTo(Product::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function commentable()
    {
        return $this->morphTo();
    }
    public function child()
    {
        return $this->hasMany(Comment::class, 'parent_id', 'id');
    }
    protected static function newFactory()
    {
        return \Modules\Comment\Database\factories\CommentFactory::new();
    }
}
