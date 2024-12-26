<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LabaRugiLevel2 extends Model
{
    use HasFactory;

    protected $fillable = [
        'level_one_id',
        'level_two',
        'is_shown',
        'tahun',
        'bulan',
        'total_this_month',
        'total_till_this_month'
    ];
}
