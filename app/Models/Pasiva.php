<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pasiva extends Model
{
    use HasFactory;
    protected $fillable = ['kode_pasiva', 'jenis_pasiva', 'nilai', 'deskripsi'];

}
