<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Picture extends Model
{
    use HasFactory;
    protected $table='pictures';
    protected $fillable=['id_product','picture'];

    public function product()
    {
        return $this->belongsTo('App\Models\Product');
    }
}
