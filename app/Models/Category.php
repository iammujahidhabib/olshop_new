<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class Category extends Model
{
    use HasFactory;
    // public $timestamps = true;
    protected $table='categories';
    protected $fillable=['category'];
    public function product()
    {
        return $this->hasMany('App\Models\Product');
    }
}
