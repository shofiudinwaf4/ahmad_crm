<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectModel extends Model
{
    protected $table = 'proyek';
    protected $fillable = ['id_user', 'id_lead', 'id_produk', 'harga_jual', 'permintaan_harga',  'status', 'status_project'];

    public function lead()
    {
        return $this->belongsTo(leadsModel::class, 'id_lead');
    }

    public function produk()
    {
        return $this->belongsTo(produkModel::class, 'id_produk');
    }
    public function sales()
    {
        return $this->belongsTo(User::class, 'id_produk');
    }
}
