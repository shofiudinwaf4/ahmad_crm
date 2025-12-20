<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class produkModel extends Model
{
    protected $table = 'produks';
    protected $fillable = ['nama_produk', 'hpp', 'margin', 'harga_jual'];

    public function customers()
    {
        return $this->belongsToMany(
            pelangganModel::class,
            'customer_produk',
            'id_produk',
            'id_customer'
        )->withPivot('no_langganan')
            ->withTimestamps();
    }
}
