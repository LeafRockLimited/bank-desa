<?php

namespace App\Models;

use Database\Factories\JenisSimpananFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisSimpanan extends Model
{
    use HasFactory;

    protected $table = 'simpanan_jenis';

    protected $fillable = ['nama_jenis_simpanan', 'minimal_setoran', 'bunga_simpanan','bisa_dicairkan'];

    static function newFactory()
    {
        return JenisSimpananFactory::new();
    }

    public function simpanan()
    {
        return $this->hasMany(Simpanan::class);
    }
}
