<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Presupuesto_HeadCount extends Model
{
    use HasFactory;

    
    protected $table ='vi_g6_presupuesto_vs_headcount';
    // protected $id='IdRemuneracion';
    protected $fillable=["gestion","mes","headcount","presupuesto"];

}
