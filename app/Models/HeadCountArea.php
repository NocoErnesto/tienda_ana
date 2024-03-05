<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HeadCountArea extends Model
{
    use HasFactory;

    protected $table ='v_g2_headcount_centro_costo';
    // protected $id='IdRemuneracion';
    protected $fillable=["Area","cantidad","MesReporte"];

}
