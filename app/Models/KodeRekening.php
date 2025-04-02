<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KodeRekening extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'module', 
        'nomor_rekening', 
        'nama_rekening', 
        'deskripsi', 
        'parent_id', 
        'saldo_normal'
    ];

    /**
     * Relasi ke parent COA
     */
    public function parent()
    {
        return $this->belongsTo(KodeRekening::class, 'parent_id');
    }

    /**
     * Relasi ke child COA
     */
    public function children()
    {
        return $this->hasMany(KodeRekening::class, 'parent_id');
    }
}
