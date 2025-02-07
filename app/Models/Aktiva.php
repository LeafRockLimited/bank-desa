<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aktiva extends Model
{
    use HasFactory;
    protected $fillable = ['kode_aktiva', 'jenis_aktiva', 'nilai', 'deskripsi'];

}
