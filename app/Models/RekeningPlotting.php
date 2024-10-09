<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RekeningPlotting extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_rekening_id',
        'slug',
    ];

    
}
