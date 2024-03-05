<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class comparativoTC extends Model
{
    use HasFactory;
    protected $table ='vi_g5_tipocontrato_presupuesto';
    // protected $id='IdRemuneracion';
    protected $fillable=["gestion","mes","TipoContrato","headcount","presupuesto"];
}
