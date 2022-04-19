<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = "transaksi";
    protected $guarded = ["id"];

    public function transaksi_detail(){
        return $this->hasMany(TransaksiDetail::class);
        
    }
    public function user() {
        return $this->belongsTo(User::class);
    }
}
