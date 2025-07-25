<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Products extends Model
{
    protected $fillable = [
        'seller_id',
        'category_id',
        'name',
        'description',
        'price',
        'stock',
        'image',
        'is_active'
    ];

    public function category() :BelongsTo 
    {
      return  $this->belongsTo(Category::class,'category_id');
    }

    public function seller() :BelongsTo {
       return $this->belongsTo(User::class, 'seller_id') ;
    }
}
