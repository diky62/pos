<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangMasuk extends Model
{
    use HasFactory;

    protected $table = "barang_masuk";
    protected $guarded = ["id"];

    public function produk(){
    	return $this->belongsTo(Produk::class);
    }
}
