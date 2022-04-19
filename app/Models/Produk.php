<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    protected $table = "produk";
    protected $guarded = ["id"];


    public function kategori(){
    	return $this->belongsTo(Kategori::class);
    }

    public function barang_masuk(){
        return $this->hasMany(BarangMasuk::class);
    }
    public function transaksi_detail(){
        return $this->hasMany(TransaksiDetail::class);
    }
    public function carts() {
        return $this->hasOne(Carts::class);
    }
    
}
