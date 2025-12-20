<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class pelangganModel extends Model
{
    protected $table = 'customers';

    protected $fillable = ['id_user', 'no_pelanggan', 'nama', 'kontak', 'alamat', 'is_active'];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function layanan()
    {
        return $this->hasMany(CustomerLayananModel::class, 'id_customer');
    }
}
