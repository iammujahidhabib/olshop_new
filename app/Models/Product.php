<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use App\Mode
// use App\Models\Category

class Product extends Model
{
    use HasFactory;
    protected $table='products';
    protected $fillable=['product','stock','price','desc','id_category'];

    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }
    public function picture()
    {
        return $this->hasMany('App\Models\Picture');
    }
}
