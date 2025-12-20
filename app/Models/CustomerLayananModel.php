<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerLayananModel extends Model
{
    protected $table = 'customer_layanan';
    protected $fillable = ['id_customer', 'nama_layanan', 'no_langganan', 'tagihan', 'is_active'];

    public function customer()
    {
        return $this->belongsTo(pelangganModel::class, 'id_customer');
    }
}
