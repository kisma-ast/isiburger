<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Burger extends Model
{
    //
    use HasFactory;
    protected $fillable = ['name','price','image','description','stock','is_archived'];


    // rELATION AVEC COMMANDEPROD
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }


    // Gere le stock sil > a 0
    public function isInStock()
    {
        return $this->stock > 0;
    }

    public function scopeAvailable($query)
    {
        return $query->where('is_archived', false)->where('stock', '>', 0);
    }
}
