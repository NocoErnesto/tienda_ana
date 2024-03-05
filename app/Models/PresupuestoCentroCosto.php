<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PresupuestoCentroCosto extends Model
{
    use HasFactory;
     
    protected $table ='vi_g7_centro_costo_presupuesto';
    // protected $id='IdRemuneracion';
    protected $fillable=["gestion","mes","headcount","presupuesto"];
}
