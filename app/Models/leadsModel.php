<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class leadsModel extends Model
{
    protected $table = 'leads';

    protected $fillable = ['id_user', 'nama', 'kontak', 'alamat', 'status', 'kebutuhan'];

    public function sales()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function project()
    {
        return $this->hasMany(ProjectModel::class, 'id_lead');
    }
}
