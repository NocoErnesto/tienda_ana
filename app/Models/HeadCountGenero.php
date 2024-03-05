<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HeadCountGenero extends Model
{
    use HasFactory;
    protected $table ='vi_g3_totalmf';
    // protected $id='IdRemuneracion';
    protected $fillable=["MesReporte","cant_m","cant_f"];
}
