<?php

namespace Modules\Gallery\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductGallery extends Model
{
    use HasFactory;

    protected $fillable = ['image', 'alt'];
    
    protected static function newFactory()
    {
        return \Modules\Gallery\Database\factories\ProductGalleryFactory::new();
    }
}
