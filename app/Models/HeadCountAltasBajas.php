<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HeadCountAltasBajas extends Model
{
    use HasFactory;
    protected $table ='vi_g4_alta_baja';
    // protected $id='IdRemuneracion';
    protected $fillable=["MesReporte","total_baja","total_Alta",];
}
