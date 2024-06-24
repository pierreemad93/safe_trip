<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;
    protected $fillable = ["name", "brand", "model", "color", "plate_number", "production_date", "type_id", 'price', 'discount', 'price_after_discount'];

    public function type()
    {
        return $this->belongsTo(Type::class);
    }
}
