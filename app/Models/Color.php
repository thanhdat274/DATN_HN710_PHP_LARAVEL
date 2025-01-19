<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Color extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['name', 'hex_code'];

    public function productVariants()
    {
        return $this->hasMany(ProductVariant::class);
    }
}
