<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Produk;

class Carts extends Model
{
    use HasFactory;
    protected $table = "carts";
    protected $guarded = ["id"];

    public function produk(){
    	return $this->belongsTo(Produk::class);
    }
}
