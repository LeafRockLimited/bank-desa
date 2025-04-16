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

    protected $appends = [
        'level_one',
        'level_two',
        'level_three',
        'level_four',
        'level_five',
        // Tambahkan jika kamu punya lebih banyak level
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

    /**
     * Helper untuk memecah nomor rekening
     */
    protected function getNomorRekeningParts()
    {
        return explode('.', $this->nomor_rekening ?? '');
    }

    public function getLevelOneAttribute()
    {
        return $this->getNomorRekeningParts()[0] ?? null;
    }

    public function getLevelTwoAttribute()
    {
        return $this->getNomorRekeningParts()[1] ?? null;
    }

    public function getLevelThreeAttribute()
    {
        return $this->getNomorRekeningParts()[2] ?? null;
    }

    public function getLevelFourAttribute()
    {
        return $this->getNomorRekeningParts()[3] ?? null;
    }

    public function getLevelFiveAttribute()
    {
        return $this->getNomorRekeningParts()[4] ?? null;
    }
}
